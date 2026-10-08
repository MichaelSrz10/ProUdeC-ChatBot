<?php

namespace Tests\Unit\Chatbot;

use App\Services\Chatbot\Exceptions\ChatbotUnavailableException;
use App\Services\Chatbot\KnowledgeBase;
use Tests\TestCase;

class KnowledgeBaseTest extends TestCase
{
    public function test_real_knowledge_files_validate_and_have_unique_ids(): void
    {
        $base = new KnowledgeBase(resource_path('knowledge'));
        $entries = $base->entries();
        $ids = array_map(fn (array $entry) => $entry['id'], $entries);

        $this->assertNotEmpty($entries);
        $this->assertSame(count($ids), count(array_unique($ids)));

        foreach ($entries as $entry) {
            $this->assertNotSame('', trim($entry['content']['es']));
            $this->assertNotSame('', trim($entry['content']['en']));
            $this->assertFileExists(base_path($entry['source']));
        }

        $this->assertStringContainsString('ProUDEC', $base->contextFor('es'));
    }

    public function test_corrupt_json_makes_knowledge_unavailable(): void
    {
        $dir = sys_get_temp_dir().'/proudec-kb-'.uniqid();
        mkdir($dir);
        file_put_contents($dir.'/broken.json', '{not json');

        $this->expectException(ChatbotUnavailableException::class);
        (new KnowledgeBase($dir))->entries();
    }

    public function test_missing_source_file_is_rejected(): void
    {
        $dir = sys_get_temp_dir().'/proudec-kb-'.uniqid();
        mkdir($dir);
        file_put_contents($dir.'/bad.json', json_encode([
            'schema_version' => '1.0',
            'category' => 'test',
            'entries' => [[
                'id' => 'test-001',
                'topic' => ['es' => 't', 'en' => 't'],
                'content' => ['es' => 'c', 'en' => 'c'],
                'keywords' => ['es' => ['a'], 'en' => ['a']],
                'source' => 'does-not-exist.md',
                'last_verified' => '2026-10-07',
            ]],
        ]));

        $this->expectException(ChatbotUnavailableException::class);
        (new KnowledgeBase($dir))->entries();
    }

    public function test_duplicate_ids_are_rejected(): void
    {
        $dir = sys_get_temp_dir().'/proudec-kb-'.uniqid();
        mkdir($dir);
        $entry = [
            'id' => 'dup-001',
            'topic' => ['es' => 't', 'en' => 't'],
            'content' => ['es' => 'c', 'en' => 'c'],
            'keywords' => ['es' => ['a'], 'en' => ['a']],
            'source' => 'README.md',
            'last_verified' => '2026-10-07',
        ];
        file_put_contents($dir.'/a.json', json_encode(['entries' => [$entry]]));
        file_put_contents($dir.'/b.json', json_encode(['entries' => [$entry]]));

        $this->expectException(ChatbotUnavailableException::class);
        (new KnowledgeBase($dir))->entries();
    }

    public function test_empty_bilingual_content_is_rejected(): void
    {
        $dir = sys_get_temp_dir().'/proudec-kb-'.uniqid();
        mkdir($dir);
        file_put_contents($dir.'/empty.json', json_encode([
            'entries' => [[
                'id' => 'empty-001',
                'topic' => ['es' => 't', 'en' => 't'],
                'content' => ['es' => ' ', 'en' => 'ok'],
                'keywords' => ['es' => ['a'], 'en' => ['a']],
                'source' => 'README.md',
                'last_verified' => '2026-10-07',
            ]],
        ]));

        $this->expectException(ChatbotUnavailableException::class);
        (new KnowledgeBase($dir))->entries();
    }
}
