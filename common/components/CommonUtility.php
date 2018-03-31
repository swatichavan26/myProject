<?php

namespace common\components;

/**
 * Description of commonUtility
 *
 * @author Swati Chavan <swati.c@infinitylabs.in>
 */
class CommonUtility extends \yii\base\Component {

    public function getUserId() {
        $user = \Yii::$app->user->identity->id;
        return $user;
    }

    public static function getUserName($userId) {
        $userModel = \common\models\User::find()
                ->where(['id' => $userId])
                ->one();
        if ($userModel) {
            return $userModel->username;
        }
    }

    public static function convertCSSNIPHtmlToText($html, $sapid, $encoding = 'UTF-8', $keepIndentation = false) {
        $textContent = self::convertHtmlToText($html, $encoding);
        $textContent = str_replace(array("\r\n", "\r"), "\n", $textContent);
        $textContent = str_replace("Network Implementation Plan - CSS {$sapid}", "", $textContent);
        $textContent = str_replace("<Document No.>", "", $textContent);
        $lines = explode("\n", $textContent);
        $new_lines = array();

        foreach ($lines as $i => $line) {
            if (!empty($line)) {
                if (!$keepIndentation) {
                    $line = trim($line);
                }
                $new_lines[] = $line;
            }
        }
        $new_lines = array_values(array_filter($new_lines));
        $textContent = implode("\r\n", $new_lines);
        return $textContent;
    }
    
    public static function convertHtmlToText($html, $encoding = 'UTF-8') {
        $html = str_replace("&nbsp;", "[[SPACE]]", $html);
        $textContent = strip_tags($html);
        $textContent = array_map('trim', explode("\n", $textContent));
        $textContent = str_replace("[[SPACE]]", chr(32), $textContent);
        $textContent = implode("\n", $textContent);
        $textContent = html_entity_decode($textContent, ENT_QUOTES, $encoding);
        return $textContent;
    }

}
