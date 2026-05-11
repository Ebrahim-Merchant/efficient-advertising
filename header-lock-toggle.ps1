param(
    [ValidateSet('lock','unlock','status')]
    [string]$Action = 'status',

    [string]$Password
)

$ErrorActionPreference = 'Stop'

$headerPath = Join-Path $PSScriptRoot 'wp-content\themes\NewEfficientAdvtWorkingTheme_v1.0\header.php'
$expectedHash = 'f8c999953a0081371d25912196c456ae3eda435948e69fdd61e70a40301d53ab'

function Get-SHA256Hash {
    param([Parameter(Mandatory = $true)][string]$Text)

    $sha = [System.Security.Cryptography.SHA256]::Create()
    try {
        $bytes = [System.Text.Encoding]::UTF8.GetBytes($Text)
        return ($sha.ComputeHash($bytes) | ForEach-Object { $_.ToString('x2') }) -join ''
    }
    finally {
        $sha.Dispose()
    }
}

function Assert-ValidPassword {
    param([Parameter(Mandatory = $true)][string]$Candidate)

    if ([string]::IsNullOrWhiteSpace($Candidate)) {
        throw 'Password is required for lock/unlock actions.'
    }

    $candidateHash = Get-SHA256Hash -Text $Candidate
    if ($candidateHash -ne $expectedHash) {
        throw 'Invalid password. Header lock state was not changed.'
    }
}

if (-not (Test-Path -LiteralPath $headerPath)) {
    throw "header.php not found at: $headerPath"
}

$file = Get-Item -LiteralPath $headerPath
$isReadOnly = (($file.Attributes -band [System.IO.FileAttributes]::ReadOnly) -ne 0)

switch ($Action) {
    'status' {
        if ($isReadOnly) {
            Write-Output "LOCKED: $headerPath"
        }
        else {
            Write-Output "UNLOCKED: $headerPath"
        }
        break
    }

    'lock' {
        Assert-ValidPassword -Candidate $Password

        if (-not $isReadOnly) {
            $file.Attributes = ($file.Attributes -bor [System.IO.FileAttributes]::ReadOnly)
            $file = Get-Item -LiteralPath $headerPath
        }

        Write-Output "LOCKED: $headerPath"
        break
    }

    'unlock' {
        Assert-ValidPassword -Candidate $Password

        if ($isReadOnly) {
            $file.Attributes = ($file.Attributes -band (-bnot [System.IO.FileAttributes]::ReadOnly))
            $file = Get-Item -LiteralPath $headerPath
        }

        Write-Output "UNLOCKED: $headerPath"
        break
    }
}
