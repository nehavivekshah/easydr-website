# 🚀 EASYDOCTOR - GITHUB & PRODUCTION DEPLOYMENT GUIDE

## STEP-BY-STEP: Development → GitHub → Live Site

Date: January 2026
Domain: dr.webbrella.in
Status: Ready for Deployment

---

## 📋 PREREQUISITES

Before starting, ensure you have:
- ✅ GitHub account (github.com)
- ✅ Git installed locally
- ✅ SSH keys configured (or Personal Access Token)
- ✅ Server access (hosting provider)
- ✅ SSH/FTP access to dr.webbrella.in
- ✅ Database credentials for production
- ✅ Composer & Node.js installed

---

## PHASE 1: GITHUB SETUP (15 minutes)

### Step 1.1: Create GitHub Repository

1. Go to https://github.com/new
2. Create repository:
   - **Repository name:** `easyDoctor` (or `easy-doctor`)
   - **Description:** "Professional Healthcare Platform"
   - **Public/Private:** Choose based on preference
   - **Initialize with:** Add .gitignore (Laravel), Add license, Add README
3. Click "Create repository"

### Step 1.2: Copy Repository URL

After creating, you'll see:
```
https://github.com/YOUR_USERNAME/easyDoctor.git
```

Keep this URL ready for next steps.

### Step 1.3: Generate GitHub Personal Access Token (if using HTTPS)

1. Go to https://github.com/settings/tokens
2. Click "Generate new token"
3. Give it access to: `repo`, `workflow`, `admin:repo_hook`
4. Copy and save the token securely

---

## PHASE 2: LOCAL REPOSITORY SETUP (20 minutes)

### Step 2.1: Initialize Git in Your Project

Open PowerShell/Terminal in your project directory:

```bash
cd c:\Users\6315\Desktop\MobileApps\RND\EasyDoctor\website
git init
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

### Step 2.2: Create .gitignore File

Create file: `c:\Users\6315\Desktop\MobileApps\RND\EasyDoctor\website\.gitignore`

```
# Environment variables
.env
.env.local
.env.*.local

# Dependencies
node_modules/
vendor/

# Build files
public/hot
public/storage
storage/

# Cache
bootstrap/cache/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/

# Logs
storage/logs/

# IDE
.vscode/
.idea/
*.swp
*.swo
*~
.DS_Store

# OS
Thumbs.db

# Database
*.sqlite
database/*.sqlite

# Temporary files
*.tmp
tmp/

# Node
npm-debug.log
yarn-error.log
package-lock.json (if using yarn instead)

# PHP
.phpunit.result.cache

# Compiled assets (if using npm)
# public/css/
# public/js/
```

### Step 2.3: Add All Files to Git

```bash
git add .
git status  # Review what will be committed
```

### Step 2.4: Create Initial Commit

```bash
git commit -m "Initial commit: EasyDoctor Frontend - Production Ready

- 32 frontend files created
- 25+ pages fully functional
- 1550+ lines of responsive CSS
- 315+ lines of JavaScript
- Complete documentation
- Ready for deployment"
```

### Step 2.5: Add Remote Repository

Replace `YOUR_USERNAME` and `REPO_NAME`:

```bash
git remote add origin https://github.com/YOUR_USERNAME/easyDoctor.git
```

Verify it worked:
```bash
git remote -v
# Should show:
# origin  https://github.com/YOUR_USERNAME/easyDoctor.git (fetch)
# origin  https://github.com/YOUR_USERNAME/easyDoctor.git (push)
```

### Step 2.6: Push to GitHub

```bash
git branch -M main
git push -u origin main
```

When prompted for password, use your Personal Access Token (not your GitHub password).

✅ **Your code is now on GitHub!**

---

## PHASE 3: DEPLOYMENT TO PRODUCTION (30 minutes)

### Step 3.1: SSH into Your Server

```bash
ssh user@dr.webbrella.in
# Or use your hosting provider's SSH details
```

### Step 3.2: Navigate to Web Root

```bash
cd /var/www/html
# or wherever your web files are stored
ls -la  # Check current files
```

### Step 3.3: Backup Current Site

```bash
# Backup current version
cp -r ./ ./backup_$(date +%Y%m%d_%H%M%S)

# Backup database
mysqldump -u root -p easyDoctor > backup_db_$(date +%Y%m%d_%H%M%S).sql
```

### Step 3.4: Clone Repository to Server

```bash
cd /var/www/html
git clone https://github.com/YOUR_USERNAME/easyDoctor.git .
# Or if already exists:
git pull origin main
```

### Step 3.5: Setup Production Environment

```bash
# Copy environment file
cp .env.example .env

# Edit .env with production settings
nano .env
# Update:
# APP_ENV=production
# APP_DEBUG=false
# DB_HOST=localhost
# DB_DATABASE=easyDoctor
# DB_USERNAME=your_db_user
# DB_PASSWORD=your_db_password
```

### Step 3.6: Install Dependencies

```bash
# Install PHP dependencies
composer install --no-dev

# Install Node dependencies
npm install --production

# Build production assets
npm run build
```

### Step 3.7: Generate Application Key

```bash
php artisan key:generate
```

### Step 3.8: Run Database Migrations

```bash
# Option 1: If fresh database
php artisan migrate --seed

# Option 2: If migrating from old system
php artisan migrate
```

### Step 3.9: Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 3.10: Set File Permissions

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/html

# Set permissions
chmod -R 755 /var/www/html
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

# Storage link for files
php artisan storage:link
```

### Step 3.11: Configure Web Server (NGINX)

If using NGINX, update your server block:

File: `/etc/nginx/sites-available/dr.webbrella.in`

```nginx
server {
    listen 80;
    server_name dr.webbrella.in www.dr.webbrella.in;
    
    root /var/www/html/public;
    index index.php index.html index.htm;
    
    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name dr.webbrella.in www.dr.webbrella.in;
    
    root /var/www/html/public;
    index index.php index.html index.htm;
    
    # SSL Configuration
    ssl_certificate /etc/ssl/certs/your_cert.crt;
    ssl_certificate_key /etc/ssl/private/your_key.key;
    
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    
    # Gzip compression
    gzip on;
    gzip_types text/plain text/css text/xml text/javascript 
               application/x-javascript application/xml+rss 
               application/javascript application/json;
    
    # Laravel rewrite rules
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
}
```

Reload NGINX:
```bash
sudo systemctl reload nginx
```

### Step 3.12: Configure Web Server (Apache)

If using Apache, ensure `.htaccess` is in place:

File: `/var/www/html/public/.htaccess` (already included)

Enable mod_rewrite:
```bash
sudo a2enmod rewrite
sudo systemctl reload apache2
```

### Step 3.13: Setup SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d dr.webbrella.in -d www.dr.webbrella.in
```

### Step 3.14: Test Website

```bash
# Test from server
curl -H "Host: dr.webbrella.in" http://localhost
# Or visit: https://dr.webbrella.in in browser
```

---

## PHASE 4: POST-DEPLOYMENT VERIFICATION (20 minutes)

### Step 4.1: Test All Pages

Visit in browser:
- [ ] Homepage: `https://dr.webbrella.in/`
- [ ] About: `https://dr.webbrella.in/about-us`
- [ ] Services: `https://dr.webbrella.in/services`
- [ ] Contact: `https://dr.webbrella.in/contact-us`
- [ ] Doctors: `https://dr.webbrella.in/doctors`
- [ ] Pharmacy: `https://dr.webbrella.in/pharmacy`
- [ ] Blog: `https://dr.webbrella.in/blog`
- [ ] Login: `https://dr.webbrella.in/login`
- [ ] Signup: `https://dr.webbrella.in/signup`

### Step 4.2: Test Mobile Responsiveness

- [ ] Open in mobile browser
- [ ] Check all pages render correctly
- [ ] Test touch interactions
- [ ] Verify navigation menu

### Step 4.3: Test Forms

- [ ] Contact form submission
- [ ] Appointment booking
- [ ] Newsletter signup
- [ ] User login/signup

### Step 4.4: Check Console for Errors

- [ ] Open DevTools (F12)
- [ ] Check Console tab for JavaScript errors
- [ ] Check Network tab for 404s
- [ ] Check for warnings

### Step 4.5: Performance Check

- [ ] Page load time < 3 seconds
- [ ] Lighthouse score > 90
- [ ] No render-blocking resources
- [ ] Images loading properly

### Step 4.6: Security Check

- [ ] HTTPS working (lock icon visible)
- [ ] No mixed content warnings
- [ ] Security headers present
- [ ] Forms have CSRF tokens

---

## PHASE 5: ONGOING UPDATES (Weekly)

### To Deploy Updates:

```bash
# On your local machine
git add .
git commit -m "Update: Description of changes"
git push origin main

# On production server
cd /var/www/html
git pull origin main
composer install --no-dev
npm install --production
npm run build
php artisan config:cache
php artisan view:cache
```

---

## 📊 DEPLOYMENT CHECKLIST

### Before Going Live
- [ ] GitHub repository created and code pushed
- [ ] Production environment configured (.env)
- [ ] Database migrations run
- [ ] SSL certificate installed
- [ ] File permissions set correctly
- [ ] Email configured for notifications
- [ ] Payment gateway configured (if needed)
- [ ] Backup of old site created

### After Going Live
- [ ] All pages accessible
- [ ] No console errors
- [ ] Forms working
- [ ] Mobile responsive
- [ ] HTTPS working
- [ ] Page speed acceptable
- [ ] Analytics configured
- [ ] Error logging enabled
- [ ] Database backups scheduled
- [ ] Monitoring alerts set up

---

## 🔧 TROUBLESHOOTING

### Issue: 500 Internal Server Error

```bash
# Check error logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check file permissions
sudo chown -R www-data:www-data .
chmod -R 755 .
chmod -R 777 storage bootstrap/cache
```

### Issue: Database Connection Error

```bash
# Test database connection
php artisan tinker
# In tinker: DB::connection()->getPdo();

# Check .env database settings
cat .env | grep DB_

# Create database if needed
mysql -u root -p
CREATE DATABASE easyDoctor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Issue: Assets Not Loading (CSS/JS 404)

```bash
npm run build
php artisan storage:link
sudo chown -R www-data:www-data public/
```

### Issue: Git Push Authentication Error

```bash
# If using HTTPS, use Personal Access Token as password
# If using SSH, ensure keys are configured:
ssh-keygen -t rsa -b 4096 -f ~/.ssh/id_rsa
# Add public key to GitHub Settings → SSH Keys
```

---

## 📈 MONITORING & MAINTENANCE

### Daily Checks
- Check error logs: `tail -f storage/logs/laravel.log`
- Monitor uptime
- Check disk space: `df -h`
- Check memory: `free -h`

### Weekly Tasks
- Backup database
- Review error logs
- Update dependencies: `composer update`
- Check security updates

### Monthly Tasks
- Performance analysis
- User feedback review
- Database optimization
- Security audit

---

## 📞 SUPPORT & REFERENCES

### Important Commands

```bash
# Git commands
git status              # Check current status
git log                 # View commit history
git diff                # See changes
git stash               # Temporarily save changes
git restore .           # Discard local changes

# Laravel commands
php artisan serve                   # Start dev server
php artisan migrate                 # Run migrations
php artisan db:seed                 # Seed database
php artisan queue:work              # Process queues
php artisan schedule:work           # Process schedules
php artisan tinker                  # Interactive shell

# Server commands
systemctl restart nginx              # Restart NGINX
systemctl restart apache2            # Restart Apache
systemctl restart php8.2-fpm        # Restart PHP-FPM
tail -f /var/log/nginx/error.log   # View NGINX errors
tail -f /var/log/apache2/error.log # View Apache errors
```

### Useful Links

- GitHub Docs: https://docs.github.com
- Laravel Docs: https://laravel.com/docs
- NGINX Docs: https://nginx.org/en/docs/
- Let's Encrypt: https://letsencrypt.org/

---

## ✅ FINAL STATUS

Once you've completed all phases:
- ✅ Code on GitHub
- ✅ Live on dr.webbrella.in
- ✅ SSL enabled
- ✅ All pages working
- ✅ Database configured
- ✅ Ready for users

---

## 🎊 YOU'RE LIVE!

Your EasyDoctor platform is now live and ready to serve patients!

**Next Steps:**
1. Share link with users
2. Monitor error logs
3. Collect user feedback
4. Make improvements

---

**Version:** 1.0.0
**Date:** January 2026
**Status:** Ready for Deployment
