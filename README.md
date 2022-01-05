# LaraBot Framework

## 説明
チャットbotアプリケーションを簡単に構築するためのLaravel製フレームワークです。

### ユースケース
- チャットbotの動作をPHPで自由にカスタマイズする🤖
- Laravelタスクスケジュールで定期的にチャットbotに通知させる📅
- IoT機器が取得した情報をチャットbotに通知させる🏠

## 環境

開発環境のテンプレートに [ucan-lab / docker-laravel](https://github.com/ucan-lab/docker-laravel) を使わせていただいています。

### プロジェクトのビルド
```shell
cd LaraBotFramework
make init
```

### 起動
```shell
make up
```

### 環境設定

#### Messaging Api

LINE Developersコンソールで取得したチャネルアクセストークン・チャネルシークレットを ```backend/.env```に設定してください。
```shell
MESSAGING_API_CHANNEL_ACCESS_TOKEN='{your channel access token}'
MESSAGING_API_CHANNEL_SECRET='{your channel access secret}'
MESSAGING_API_SENDER_NAME='{your sender name}'
MESSAGING_API_SENDER_ICON_URL='{your sender icon url}'
```

LINE Developersコンソールより```Webhook URL```に以下を設定してください。

```https://{Your Server Domain}/api/messagingApi```

##### 参考

[Messaging APIを始めよう](https://developers.line.biz/ja/docs/messaging-api/getting-started/)


## チャットBotの処理の拡張

以下の手順でチャットBotの処理を拡張することができます。

1. ```backend/app/UseCases/{BotApi}```に、```***UseCase.php```を作成
2. ```***UseCase::verify()```に実行条件の実装
3. ```***UseCase::exec()```に実行内容の実装

作成したUseCaseクラスが```Class Not Found```になってしまう時は、```make composer dump-autoload```でオートロードの再構築を試してみてください。

## フレームワーク設計

クリーンアーキテクチャで実装をしています。

```text
app/
├── Domain
│     ├── Entity
│     │     ├── BotApiRequest.php
│     │     ├── BotApiResponse.php
│     │     └── MessagingApi
│     │         ├── MessagingApiRequest.php
│     │         └── MessagingApiResponse.php
│     └── ValueObject
│         └── MessagingApi
├── Http
│     ├── Controllers
│     │     └── Api
│     │          └── MessagingApiController.php
│     └── Middleware
│         └── MessagingApiSignatureVerification.php
├── Infrastructures
│     ├── BotApi
│     │     ├── BotApi.php
│     │     └── MessagingApi.php
│     ├── EloquentModels
│     └── Repositories
│         ├── MessagingApiWebhookEventRepository.php
│         └── Repository.php
└── UseCases
      ├── MessagingApi
      │     └── ExampleUseCase.php
      ├── UseCase.php
      └── UseCaseKernel.php
```

### ディレクトリと責務
| 層 | ディレクトリ | 責務 |
| -- | -- | ---- |
| Infrastructure層 | app/Infrastructures/BotApi | チャットbotの動作に必要な外部サービスへの通信 |
| Infrastructure層 | app/Infrastructures/Repositories | データストアへの格納、Entityの取得 |
| Infrastructure層 | app/Infrastructures/EloquentModels | EloquentのModelクラスを格納 |
| Application層 | app/Http/Controllers | HTTPリクエストのルーティング（Laravel通常）|
| Application層 | app/Http/Middleware | HTTPリクエストのフィルタリング（Laravel通常）|
| UseCase層 | app/UseCases | チャットbotの処理 |
| Domain層 | app/Domain/Entity | UseCase層を処理するために必要なEntity |
| Domain層 | app/Domain/ValueObject | UseCase層を処理するために必要なValueObject |
