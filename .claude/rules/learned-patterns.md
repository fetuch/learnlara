# Learned Patterns

Reguły wyciągnięte z rozwiązanych problemów w docs/solutions/. Zarządzane przez /dev-compound i /dev-compound-refresh.

<!-- rule-count: 3 -->

- **Status HTTP przed otwarciem SSE**: każdą decyzję o status code (np. busy→503) podejmuj PRZED `response()->eventStream()`; po otwarciu streamu status `200 text/event-stream` jest już wysłany i nie da się go zmienić. Do single-flight używaj `Cache::lock()->get()` (nieblokujący fail-fast), nie `->block()`, i zwalniaj lock w `finally`.
  Source: docs/solutions/runtime-errors/2026-06-21-single-flight-sse-busy-503.md

- **Funkcje specyficzne dla sterownika za portem + guardem**: cechy istniejące tylko na jednym sterowniku (np. `vector`/HNSW na pgsql) izoluj za interfejsem (Port–Adapter) i opakowuj migrację w `getDriverName() === 'pgsql'`, żeby domyślny suite chodził na SQLite `:memory:`. Realny backend pokrywaj testem `#[Group(...)]` (atrybut PHPUnit, nie deprecated `@group`) z `markTestSkipped` poza danym sterownikiem.
  Source: docs/solutions/testing-issues/2026-06-21-pgvector-test-strategy-sqlite-suite.md

- **useStream do POST-owego SSE + własny parser ramek**: do streamu z body używaj `@laravel/stream-vue` `useStream` (POST), nie `EventSource` (GET-only); dodaj `<meta name="csrf-token">` bo inaczej 419. `useStream` NIE parsuje ramek SSE — parser z buforem na granice chunków piszesz sam, by oddzielić `event: citations` od deltami tekstu. Na trasie SSE wyłącz buforowanie nginx (`proxy_buffering`/`fastcgi_buffering`/`gzip` off, `X-Accel-Buffering: no`).
  Source: docs/solutions/inertia-vue-issues/2026-06-21-sse-laravel-inertia-usestream.md
