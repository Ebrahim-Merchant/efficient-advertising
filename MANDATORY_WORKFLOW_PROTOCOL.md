# Mandatory Workflow Protocol — Efficient Advertising LLC

This protocol is absolute and must be followed for every task. Failure to follow these steps is a violation of the governance protocol.

## 1. Task Initialization
*   **Commit:** Perform a Git commit of the current state before any work begins.
*   **Version Control ID:** Every commit must follow the established naming convention (e.g., EA-RHYTHM-A01).

## 2. Research & Proposal
*   **Findings:** Present research, findings, and technical implications.
*   **Proposed Changes:** List every file that will be modified, created, or deleted.
*   **Awaiting Approval:** Explicitly ask for the user's approval.

## 3. The Approval Gate
*   **Approval Keyword:** The USER must say exactly **"Approved"**.
*   **Rejected Phrases:** "Approve", "Yes", "Okay", "Proceed", "Go ahead", or any other variations are NOT valid for approval.

## 4. Implementation
*   **Action:** Execute the approved changes ONLY.
*   **Self-Correction:** If unpredicted issues arise, STOP and return to Step 2.

## 5. Reporting & Verification
*   **Completion Report:** Summarize what was changed and which files were affected.
*   **Verification Request:** Explicitly ask the user: "Please verify these changes."

## 6. The Verification Gate
*   **Verification Keyword:** The USER must say exactly **"Verified"**.
*   **Rejected Phrases:** "All okay", "Fine", "Looks good", "Proceed", or any other variations are NOT valid for verification.

## 7. Task Finalization
*   **Post-Commit:** Perform a final Git commit after the "Verified" confirmation.
*   **Logbook Entry:** Document the entire instruction flow and conversation in the [Project Logbook](file:///C:/Users/pc/Local%20Sites/newefficientadvertising09042026/app/public/PROJECT_LOGBOOK_2026-04-14.md) with precise timestamps.

---
**Protocol Established:** 2026-05-09 17:08:52 (Local Time)
## 8. Live Site Lockdown & Preview Isolation
*   **Locked Status:** The live production site is strictly locked. No experimental or unapproved changes are permitted.
*   **Sandbox Priority:** All work must be executed within the `ea-` preview files (e.g., `homepage-preview-test.php`, `ea-homepage-visual-rhythm-preview.css`).
*   **Access Protocol:** If a modification to the live site is required for a final merge, the FULL Mandatory Workflow Protocol must be followed with ZERO exceptions.

## 9. Browser & Subagent Usage Restriction
*   **Strict Restriction:** The AI agent must **NEVER** initiate browser/subagent sessions, browse URLs, run website inspections, or capture screenshots unless explicitly authorized/requested by the USER.
*   **Manual Verification:** The agent must rely strictly on the USER's manual visual verification. Once code is executed, the agent must immediately ask the USER to perform the verification on their own browser.
