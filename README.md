# clarc-laravel-plugin

クリーンアーキテクチャの実装例にしたがって、必要なモジュール群をスキャフォールディングするプラグインです。

https://nrslib.com/phpcon-2019-proposal/

現在開発中です。

# Commands

## clarc:init

初期化コマンドです。
ClarcProvider と ClarcMiddleWare が作成されます。
ClarcProvider を Provider として登録し、ClarcMiddleWare を MiddleWare として登録してください。
ClarcProvider は後述の clarc:make 実行時にインジェクション対象を設定する箇所です。

## clarc:make

クリーンアーキテクチャの実装例にしたがって、必要なモジュール群をスキャフォールディングします。
入力に従い下記データが生成されます。

- Controller
- InputData
- InputPort
- Interactor
- OutputPort
- OutputData
- Presenter
- ViewModel
