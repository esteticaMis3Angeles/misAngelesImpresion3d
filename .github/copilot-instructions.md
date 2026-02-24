<!-- Repository: hamburguesas-webside (branch: gh-pages) -->
# Copilot instructions — hamburguesas-webside

This file tells AI coding assistants how to be immediately productive in this repository.

- Project snapshot: a small static website repository (see `README.md`). The repo currently has no build scripts or package files. Primary branch used for hosting: `gh-pages`.
- Primary goal for the assistant: make small, focused changes to the website files (HTML/CSS/JS) and update content, keeping changes minimal and easy to review.

What to look for first
- Open `README.md` and root for any `index.html`, `assets/`, `css/`, or `js/` files. If you find `package.json`, `gulpfile.js`, `webpack.config.js`, or `netlify.toml`, switch to project-specific build steps.
- Check the active branch: this repo uses `gh-pages` for published content — prefer editing that branch only when the user asks for quick content updates.

Local dev & preview
- For files that are plain HTML/CSS/JS, preview locally with a simple HTTP server. On Windows PowerShell use:
  - `python -m http.server 8000` (from repository root)
  - or `npx http-server -p 8000` if `node` is present and `http-server` is installed.
- If a build tool exists later (e.g., `npm run build`), prefer using the project scripts instead of ad-hoc commands.

Editing guidance (project-specific)
- Keep changes minimal: prefer editing the fewest files needed for the requested task (content, styles, or small JS). Avoid broad refactors.
- If adding new pages or assets, place them under a clear directory (e.g., `pages/`, `assets/images/`, `assets/css/`) and update any navigation entries in `index.html` or main layout.
- Do not introduce new dependencies (npm/Python gems) without asking the user first.

Commit and PR guidance
- Use short, descriptive commit messages: `fix(content): update hero text` or `feat(css): add responsive menu`.
- For larger changes, prefer a branch and a small PR rather than committing directly to `gh-pages`. If the user explicitly asks for a quick change to live site, note the risk and confirm before pushing.

Patterns & checks
- The repo is currently a static site — look for inline scripts or separate `.js` files. If you modify JavaScript, search for global variables or inline event handlers (e.g., `onclick` in HTML) and update both usage and definition.
- Validate produced HTML/CSS for basic issues: unmatched tags, missing alt attributes for images, and mobile responsiveness for common viewport widths.

When in doubt
- If you cannot find build scripts or configuration files, ask the user whether they expect a static edit (direct HTML/CSS/JS) or a rebuild via a toolchain.
- If you need to add tests, CI, or a build pipeline, propose the minimal change and ask for approval before implementing.

Files & locations to reference explicitly
- `README.md` — project description and starting point.
- Root `index.html` (if present) — main entry and navigation to update.
- Any `assets/`, `css/`, or `js/` directories — where static resources live.

Examples of concise tasks the assistant can perform immediately
- Update the hamburger menu text in `index.html` and adjust CSS for spacing.
- Add `alt` attributes to images found under `assets/images/`.
- Fix a simple JavaScript event handler bug in `assets/js/main.js` if present.

Please review and tell me if you want additional sections (CI, build pipeline, or deployment steps) or if there are files I should inspect that I missed.
