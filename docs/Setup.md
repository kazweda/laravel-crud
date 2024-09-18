## Laravel Sail環境
[Laravel Sail + Vite + Tailwind CSS + Laravel Breeze（認証機能）を使った開発環境の構築](https://zenn.dev/nenenemo/articles/46d43854cd01c5)

### プロジェクト作成
```
curl -s https://laravel.build/<プロジェクト名> | bash
```
### sailを起動
```
sail up -d
```

### localhostを確認
```
Internal Server Error
```
### マイグレート
```
sail artisan migrate
```

### 認証機能を追加
```
sail composer require laravel/breeze --dev
sail artisan breeze:install
```

### mailpit
mailpitサービスを使用して、実際のメールサーバーではなく、
ローカルの開発環境内でメールを受信できるようにします。
```
sail php artisan make:notification ResetPasswordNotification
```
