---
description: Automatically handle site file maintenance and cleanup
---
// turbo-all

1. Scan for orphan files and backup directories
2. Move specified folders to the Archive directory (C:\Users\merch\Local Sites 1\)
3. Generate project maps and status reports for the current site

### How to use
Tell Antigravity: "Run the maintenance workflow to [Task]"
The `// turbo-all` annotation ensures that Antigravity will skip the "Approve" button for terminal commands when performing these specific steps!

### Note on Control
If you want to **manually approve** a task instead, just tell me: "Run this task step-by-step with my approval." 
Otherwise, I will proceed as quickly as possible.
