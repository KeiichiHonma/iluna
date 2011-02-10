<?php
require_once('database.php');
class systemNewsLogic extends database
{
    public $error = array();

    function checkMust($key){
        if($_POST[$key] == ''){
            $this->error[$key] = '必須です。';
        }
    }

    function checkInt($key){
        if(!is_numeric($_POST[$key])){
            $this->error[$key] = '数値を入力してください。。';
        }
    }

    function checkParam(){
        $this->checkMust('date');
        $this->checkMust('title');
        if(count($this->error) > 0){
            global $base;
            $base->t->assign('error',$this->error);
            return FALSE;
        }
        return TRUE;
    }

    //追加系関数//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function entryNews(){
        $this->addValue(
            array(
                '_id'=>'',
                'ctime'=>time(),
                'mtime'=>time(),
                'date'=>$_POST['date'],
                'title'=>$_POST['title'],
                'news'=>$_POST['news'],
                'url'=>$_POST['url'],
                'link'=>$_POST['link'],
                'target'=>$_POST['target'],
                'press'=>$_POST['press'],
                'press_title'=>$_POST['press_title']
            )
        );
        $query = $this->insert(T_NEWS);
        $this->execute($query);
        return mysql_insert_id();
    }

    //更新系関数//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function editNews($nid){
        $this->addValue(
            array(
                'mtime'=>time(),
                'date'=>$_POST['date'],
                'title'=>$_POST['title'],
                'news'=>$_POST['news'],
                'url'=>$_POST['url'],
                'link'=>$_POST['link'],
                'target'=>$_POST['target'],
                'press'=>$_POST['press'],
                'press_title'=>$_POST['press_title']
            )
        );

        //CSVはコードの変更不可．コードの変更は画面からのみ来るoldcodeで変更可能
        $this->addCondition('_id = \''.$nid.'\'');
        $query = $this->update(T_NEWS);
        $this->execute($query);
        return TRUE;
    }

    //削除系関数//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function dropNews($nid){
        $this->addCondition('_id = \''.$nid.'\'');
        $query = $this->delete(T_NEWS);
        $this->execute($query);
    }

}
?>