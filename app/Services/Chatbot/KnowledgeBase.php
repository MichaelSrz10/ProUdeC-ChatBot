<?php

namespace App\Services\Chatbot;

use App\Services\Chatbot\Exceptions\ChatbotUnavailableException;
use Illuminate\Support\Facades\Log;
use JsonException;

class KnowledgeBase
{
    /**
     * @var list<array<string, mixed>>|null
     */
    private ?array $entries = null;

    public function __construct(
        private string $path,
        private int $maxContextChars = 48000,
    ) {}

    /**
     * @return list<array<string, mixed>>
     */
    public function entries(): array
    {
        if ($this->entries !== null) {
            return $this->entries;
        }

        $this->entries = $this->loadAndValidate();

        return $this->entries;
    }

    public function contextFor(string $language): string
    {
        $entries = $this->entries();
        $chunks = [];

        foreach ($entries as $entry) {
            $topic = $this->localized($entry['topic'] ?? [], $language);
            $content = $this->localized($entry['content'] ?? [], $language);
            $source = (string) ($entry['source'] ?? '');
            $id = (string) ($entry['id'] ?? '');

            $chunks[] = "[$id] $topic\n$content\nFuente: $source";
        }

        $text = implode("\n\n", $chunks);

        if (mb_strlen($text) > $this->maxContextChars) {
            $text = mb_substr($text, 0, $this->maxContextChars);
        }

        return $text;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function loadAndValidate(): array
    {
        if (! is_dir($this->path)) {
            Log::channel('chatbot')->error('chatbot.knowledge_missing_dir');
            throw new ChatbotUnavailableException('Knowledge directory missing.');
        }

        $files = glob($this->path.'/*.json') ?: [];

        if ($files === []) {
            Log::channel('chatbot')->error('chatbot.knowledge_empty');
            throw new ChatbotUnavailableException('Knowledge files missing.');
        }

        $entries = [];
        $ids = [];

        sort($files);

        foreach ($files as $file) {
            $raw = file_get_contents($file);

            if ($raw === false) {
                Log::channel('chatbot')->error('chatbot.knowledge_unreadable');
                throw new ChatbotUnavailableException('Knowledge file unreadable.');
            }

            try {
                /** @var mixed $decoded */
                $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                Log::channel('chatbot')->error('chatbot.knowledge_invalid_json');
                throw new ChatbotUnavailableException('Knowledge JSON invalid.');
            }

            if (! is_array($decoded) || ! isset($decoded['entries']) || ! is_array($decoded['entries'])) {
                Log::channel('chatbot')->error('chatbot.knowledge_invalid_schema');
                throw new ChatbotUnavailableException('Knowledge schema invalid.');
            }

            foreach ($decoded['entries'] as $entry) {
                if (! is_array($entry)) {
                    throw new ChatbotUnavailableException('Knowledge entry invalid.');
                }

                $this->assertEntry($entry);
                $id = (string) $entry['id'];

                if (isset($ids[$id])) {
                    Log::channel('chatbot')->error('chatbot.knowledge_duplicate_id');
                    throw new ChatbotUnavailableException('Duplicate knowledge id.');
                }

                $ids[$id] = true;
                $entries[] = $entry;
            }
        }

        return $entries;
    }

    /**
     * @param  array<string, mixed>  $entry
     */
    private function assertEntry(array $entry): void
    {
        foreach (['id', 'topic', 'content', 'keywords', 'source', 'last_verified'] as $field) {
            if (! isset($entry[$field]) || $entry[$field] === '') {
                throw new ChatbotUnavailableException('Knowledge entry missing fields.');
            }
        }

        foreach (['content'] as $bilingual) {
            if (! is_array($entry[$bilingual])
                || ! is_string($entry[$bilingual]['es'] ?? null)
                || ! is_string($entry[$bilingual]['en'] ?? null)
                || trim($entry[$bilingual]['es']) === ''
                || trim($entry[$bilingual]['en']) === '') {
                throw new ChatbotUnavailableException('Knowledge bilingual content missing.');
            }
        }

        $source = (string) $entry['source'];
        $absolute = base_path($source);

        if (! is_file($absolute)) {
            throw new ChatbotUnavailableException('Knowledge source file missing.');
        }
    }

    /**
     * @param  array<string, mixed>  $value
     */
    private function localized(array $value, string $language): string
    {
        if ($language === 'en') {
            return (string) ($value['en'] ?? $value['es'] ?? '');
        }

        if ($language === 'mixed') {
            $es = (string) ($value['es'] ?? '');
            $en = (string) ($value['en'] ?? '');

            return "ES: $es\nEN: $en";
        }

        return (string) ($value['es'] ?? $value['en'] ?? '');
    }
}
