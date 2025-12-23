Title: tests + fixes: upload/history tests, fixture, controller, reports

Summary:
- Added feature tests for upload and ISO history flows (`tests/Feature/Iso00UploadHistoryTest.php`).
- Fixed runtime issues in `Iso00Controller` (replace `back()` with `redirect()->back()` and return 404 responses for missing files).
- Added `dokumen_id` (nullable) to `iso_access_holders` fixture in `tests/_support/TestDatabaseTrait.php`.
- Added HTML/text test reports to `tests/reports/` (testdox wrapper, debug logs, summary & details pages).

Why:
- Ensure business-logic around uploads and history viewing/download/deletion is covered by tests.
- Prevent runtime errors in controller when helpers/functions are not available in tests/CLI.

Testing:
- Ran full test suite: 23 tests, all passing.

Notes for reviewer:
- The upload test simulates storage/move behavior because PHP CLI test environment does not run actual HTTP file uploads reliably; this keeps the logic verified (file naming, storing, DB insert, and file existence).
- I updated tests to use `FeatureTestTrait` helpers (e.g., `get()`, `post()`, `assertStatus()`, `assertOK()`).

Suggested PR body:
- Short summary + list of files changed + mention that all tests pass and include instructions to run `vendor/bin/phpunit`.

