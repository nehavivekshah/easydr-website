# CSS Variable Refactoring Script
# This script replaces hardcoded values with CSS variables in style.css

$cssFile = "c:\Users\6315\Desktop\MobileApps\RND\EasyDoctor\website\public\assets\frontend\css\style.css"

Write-Host "Reading CSS file..."
$content = Get-Content $cssFile -Raw

Write-Host "Replacing color values..."
# Primary and Secondary Colors
$content = $content -replace '#1E0B9B', 'var(--color-primary)'
$content = $content -replace '#1e0b9b', 'var(--color-primary)'
$content = $content -replace '#07CCEC', 'var(--color-secondary)'

# Text and Heading Colors
$content = $content -replace '#4A5764', 'var(--color-text)'
$content = $content -replace '#013243', 'var(--color-heading)'
$content = $content -replace '#676f67', 'var(--color-text-light)'
$content = $content -replace '#7e7e7e', 'var(--color-text-muted)'

# Gray Colors
$content = $content -replace '#8a8a8a', 'var(--color-gray-500)'
$content = $content -replace '#383838', 'var(--color-gray-800)'
$content = $content -replace '#555555', 'var(--color-gray-700)'
$content = $content -replace '#ccc', 'var(--color-gray-400)'
$content = $content -replace '#e6e6e6', 'var(--color-gray-300)'
$content = $content -replace '#f5f5f5', 'var(--color-gray-100)'
$content = $content -replace '#191D3B', 'var(--color-gray-900)'
$content = $content -replace '#e9eaf8', 'var(--color-gray-200)'
$content = $content -replace '#707070', 'var(--color-gray-600)'

# Background Colors
$content = $content -replace '#f5f8fa', 'var(--color-bg-light)'
$content = $content -replace '#eceff8', 'var(--color-bg-gray)'
$content = $content -replace '#00081b', 'var(--color-bg-dark)'

# Border Colors
$content = $content -replace '#f2f2f2', 'var(--color-border-light)'
$content = $content -replace '#edf2f7', 'var(--color-border-gray)'
$content = $content -replace '#2d3547', 'var(--color-border-dark)'

# White and Black
$content = $content -replace '#ffffff', 'var(--color-white)'
$content = $content -replace '#fff(?![0-9a-fA-F])', 'var(--color-white)'
$content = $content -replace '#000000', 'var(--color-black)'
$content = $content -replace '#000(?![0-9a-fA-F])', 'var(--color-black)'

Write-Host "Replacing font families..."
$content = $content -replace "'Titillium Web', sans-serif", 'var(--font-heading)'
$content = $content -replace "'Inter', sans-serif", 'var(--font-body)'
$content = $content -replace "'Poppins', sans-serif", 'var(--font-secondary)'

Write-Host "Replacing common transitions..."
$content = $content -replace 'all 0\.3s ease-out 0s', 'var(--transition-normal)'
$content = $content -replace 'all 0\.3s ease 0s', 'var(--transition-normal)'
$content = $content -replace 'all 0\.3s ease', 'var(--transition-normal)'
$content = $content -replace 'all \.3s', 'var(--transition-normal)'
$content = $content -replace 'all 0\.5s', 'var(--transition-slow)'
$content = $content -replace 'all \.5s', 'var(--transition-slow)'

Write-Host "Replacing gradients..."
$content = $content -replace 'transparent linear-gradient\(90deg, #1E0B9B 0%, #07CCEC 100%\)', 'var(--gradient-primary)'
$content = $content -replace 'transparent linear-gradient\(90deg, var\(--color-primary\) 0%, var\(--color-secondary\) 100%\)', 'var(--gradient-primary)'
$content = $content -replace 'linear-gradient\(90deg, #1E0B9B 0%, #07CCEC 100%\)', 'var(--gradient-primary)'
$content = $content -replace 'linear-gradient\(90deg, var\(--color-primary\) 0%, var\(--color-secondary\) 100%\)', 'var(--gradient-primary)'

$content = $content -replace 'transparent linear-gradient\(90deg, #07CCEC 0%, #1E0B9B 100%\)', 'var(--gradient-primary-reverse)'
$content = $content -replace 'transparent linear-gradient\(90deg, var\(--color-secondary\) 0%, var\(--color-primary\) 100%\)', 'var(--gradient-primary-reverse)'
$content = $content -replace 'linear-gradient\(90deg, #07CCEC 0%, #1E0B9B 100%\)', 'var(--gradient-primary-reverse)'
$content = $content -replace 'linear-gradient\(90deg, var\(--color-secondary\) 0%, var\(--color-primary\) 100%\)', 'var(--gradient-primary-reverse)'

$content = $content -replace 'linear-gradient\(90deg, #000 0%, #26154D 100%\)', 'var(--gradient-dark)'
$content = $content -replace 'linear-gradient\(90deg, var\(--color-black\) 0%, #26154D 100%\)', 'var(--gradient-dark)'

Write-Host "Saving updated CSS file..."
$content | Set-Content $cssFile -NoNewline

Write-Host "CSS refactoring complete!"
