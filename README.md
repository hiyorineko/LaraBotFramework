# LaraBot Framework

## 説明
チャットbotアプリケーションを構築するためのLaravel製フレームワークです。

### ユースケース
- チャットbotの返答内容をPHPを使ってカスタマイズする
- Laravel タスクスケジュールで定期的にLINEに通知をする
- IoT機器から取得した情報をLINEに通知をする

## 環境

### プロジェクトのビルド
```shell
git clone https://github.com/hiyorineko/LaraBotFramework.git
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
[Messaging APIを始めよう](https://developers.line.biz/ja/docs/messaging-api/getting-started/)

その後、LINE DevelopersコンソールのWebhook URLに以下を設定してください。
```https://{Your Server Domain}/api/messagingApi```


## チャットBotの処理の拡張

以下の手順でチャットBotの処理を拡張することができます。

1. ```backend/app/UseCases/{BotApi}```に、```***UseCase.php```を作成
2. ```***UseCase::verify()```に実行条件の実装
3. ```***UseCase::verify()```に実行内容の実装

必要に応じて```make composer dump-autoload```
