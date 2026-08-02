# Changelog — plg_system_stripcomments

## 1.6.0 – 2026-08-01
- Added Joomla Update System support (`<updateservers>` in the manifest,
  plus a Joomla-format `updates.xml` feed) — required by the Joomla
  Extensions Directory for all listings submitted after 10 Jan 2017.

## 1.5.0 – 2026-07-28
- In "Whole page" scope (`scope=all`), markers are no longer removed
  inside `<script>` and `<style>` blocks — those are now always left
  untouched (implemented via a PCRE `(*SKIP)(*FAIL)` pattern, with no
  performance cost).

## 1.4.0 – 2026-07-28
- Added Slovak localization (sk-SK) for the plugin settings and description.

## 1.3.0
- "Titles only" scope extended to also cover link text (`<a>`) — this
  catches menu items and breadcrumbs, not just headings and `<title>`.

## 1.2.0
- Added a "Scope" parameter (Whole page / Titles only – headings and
  `<title>`).

## 1.1.0
- Behavior change: instead of stripping HTML comments, the plugin now
  strips custom marker tags `{-- ... --}` (matching the original BIGSHOT
  behavior). Delimiters are configurable.

## 1.0.0
- Initial release — strips HTML comments from the rendered output via
  `onAfterRender`.
