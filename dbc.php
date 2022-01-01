<?php

Class Dbc
{
    protected $table_name;

    //1.データベース接続
    //引数：なし
    //返り値：接続結果を返す
    protected function dbConnect(){
        
        $dsn = $_ENV['DSN'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASSWORD'];

        try{
            $dbh = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

        }catch(PDOException $e){
            echo '接続失敗'. $e->getMessage();
            exit();
        };

        return $dbh;
    }

    //2.データを取得する
    //引数：なし
    //返り値：取得したデータ
    public function getAll(){ 
        $dbh = $this->dbConnect();     
        //①SQLの準備
        $sql = "SELECT * FROM $this->table_name";
        //②SQLの実行
        $stmt = $dbh->query($sql);
        //③SQLの結果を受け取る
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
    }

    // 引数：$id
    // 返り値：$result
    public function getById($id){
        if(empty($id)){
            exit('IDが不正です');
        }
        
        $dbh = $this->dbConnect();
        
        //SQL準備
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name Where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
        //結果を取得
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if(!$result){
            exit('ブログがありません');
        }

        return $result;
    }

}
    // 詳細画面を表示する流れ
    //①一覧画面からブログのidを送る
    //GETリクエストでidをURLにつけて送る

    //②詳細ページでidを受け取る
    //PHPの$_GETでidを取得

    //③idを元にデータベースから記事を取得
    //SELECT文でプレースホルダーを使う

    //④詳細ページに表示する
    //HTMLにPHPを埋め込んで表示

    // 投稿機能の流れ
    //①フォームから値を渡す
    //②フォームから値を受け取る
    //③バリデーションする
    //④トランズアクションする
    //⑤データをDBに登録する

    //編集機能について
    //①編集ボタンクリックでIDを送る
    //②IDを受け取り内容を表示
    //④編集データとIDを渡す
    //IDから探してDBを更新

?>
