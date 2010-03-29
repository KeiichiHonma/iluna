<?php
// --------------------------
// 認証エラー
// --------------------------
define('E_AUTH_USER_EMPTY',              'Y_AUTH_00001');
define('E_AUTH_PASS_EMPTY',              'Y_AUTH_00002');
define('E_AUTH_USER_EXIST',              'Y_AUTH_00003');
define('E_AUTH_PASS_NG',                 'Y_AUTH_00004');
define('E_AUTH_AUTHORITY_NG',            'Y_AUTH_00005');
// --------------------------
// ファイルシステムエラー
// --------------------------
define('E_CMMN_DIR_NO_EXIST',            'Y_CMMN_00001');
define('E_CMMN_DIR_NO_WRITE',            'Y_CMMN_00002');
define('E_CMMN_FILE_NO_WRITE',           'Y_CMMN_00003');
define('E_CMMN_FILE_EXIST',              'Y_CMMN_00004');
define('E_CMMN_FILE_BASE_SIZE',          'Y_CMMN_00005');
define('E_CMMN_FILE_FORM_SIZE',          'Y_CMMN_00006');
define('E_CMMN_FILE_PART_UPLOAD',        'Y_CMMN_00007');
define('E_CMMN_FILE_ALL_UPLOAD',         'Y_CMMN_00008');
define('E_CMMN_FILE_NOT_COPY',           'Y_CMMN_00009');
define('E_CODE_EMPTY',                   'Y_CMMN_00010');
define('E_CODE_DUPLICATION',             'Y_CMMN_00011');
define('E_MAIL_NOT_SEND',                'Y_CMMN_00012');
//define('E_MAIL_WRONG_ADDRESS',           'Y_CMMN_00013');
define('E_CMMN_CSV_WRONG',                'Y_CMMN_00014');
define('E_CMMN_PARAM_WRONG',                'Y_CMMN_00015');

// --------------------------
// userエラー
// --------------------------
define('E_USER_DELETE_LIMIT',              'Y_USER_00001');


//メッセージ//////////////////////////////////////////////////////////////////////
define('Y_AUTH_00001',            'ユーザー名は必須です');
define('Y_AUTH_00002',            'パスワードは必須です');
define('Y_AUTH_00003',            'ユーザーが存在しません');
define('Y_AUTH_00004',            '認証できませんでした');
define('Y_AUTH_00005',            '権限がありません');

define('Y_CMMN_00001',              'ディレクトリが存在しません');
define('Y_CMMN_00002',              'ディレクトリへの書き込み権限がありません');
define('Y_CMMN_00003',              'ファイルへの書き込み権限がありません');
define('Y_CMMN_00004',              '既にファイルが存在しています');
define('Y_CMMN_00005',              '基本ファイルサイズの制限値を超えています');
define('Y_CMMN_00006',              'フォームファイルサイズの制限値を超えています');
define('Y_CMMN_00007',              '一部分のみしかアップロードされていませんでした');
define('Y_CMMN_00008',              'アップロードされませんでした');
define('Y_CMMN_00009',              'ファイルコピーに失敗しました');
define('Y_CMMN_00010',              'コードが入力されていません');
define('Y_CMMN_00011',              'コードが重複しています');
define('Y_CMMN_00012',              'メールの送信に失敗しました');
//define('Y_CMMN_00013',              '有効なメールアドレスではありません');
define('Y_CMMN_00014',              'CSVファイルが不正です');
define('Y_CMMN_00015',              'パラメータが不正です');

define('Y_USER_00001',              'ユーザー数を0人にすることはできません');


?>
