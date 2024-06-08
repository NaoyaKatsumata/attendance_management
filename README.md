# attendance_management
<h1>出退勤登録アプリ</h1>
<img src="/topscreen.png">
<h1>概要</h1>
<p>正当な人事評価を行うため各従業員の勤務時間を把握するためのアプリケーション</p>
<h1>githubリンク</h1>
<p>https://github.com/NaoyaKatsumata/attendance_management/blob/main/README.md#test</p>
<h1>機能</h1>
<ul>
    <li>ユーザ登録</li>
    <li>ログイン</li>
    <li>出退勤登録</li>
    <li>休憩登録</li>
    <li>日付ごとの出勤履歴の表示</li>
</ul>
<h1>使用技術</h1>
<ul>
    <li>laravel:9.52.16</li>
    <li>php:8.3.6</li>
    <li>Composer:2.7.2</li>
    <li>DB:MySQL</li>
</ul>
<h1>テーブル設計</h1>
<p>attends_table</p>
<img src="/attends_table.png">
<p>break_times_table</p>
<img src="/break_times_table.png">
<p>users_table</p>
<img src="/users_table.png">
<h1>ER図</h1>
<img src="/ER_attends.png">
<img src="/ER_breakTimes.png">
<h1>環境構築</h1>
<ul>
    <li>任意のフォルダに移動</li>
    <li>
        フォルダをローカルに保存<br>
        git@github.com:NaoyaKatsumata/attendance_management.git
    </li>
    <li>
        docker-composeをビルド<br>
        docker-compose up -d --build
    </li>
    <li>
        composerのインストール<br>
        docker-compose exec php bash
        composer install
    </li>
    <li>
        .envファイルの作成<br>
        cp .env.example .env<br>
        .envファイルの書き換え<br>
        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=任意のDB名
        DB_USERNAME=任意のユーザ名
        DB_PASSWORD=任意のパスワード
    </li>
    <li>
        dockerスタート
    </li>
    <li>
        localhostへアクセス
    </li>
</ul>