# Pruebas

Ejecutar:

```bash
php artisan test
```

o `composer test`.

Las pruebas del chatbot simulan Gemini con `Http::fake`. No requieren una clave real. `phpunit.xml` define una clave ficticia que no usa el prefijo de claves reales de Google.

Cobertura del módulo: endpoint, dominio cerrado, bilingüismo, inyección, fallos de API, `KnowledgeBase`, `PromptBuilder`, `InputGuard`, y ausencia del patrón `AIza` en archivos versionados.
