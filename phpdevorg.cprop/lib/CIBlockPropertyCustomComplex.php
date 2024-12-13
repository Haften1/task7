<?php
IncludeModuleLangFile(__FILE__);


class CIBlockPropertyCustomComplex
{
  
    public static function GetUserTypeDescription()
    {
        return [
            "PROPERTY_TYPE" => "S", 
            "USER_TYPE" => "custom_complex_editor", 
            "DESCRIPTION" => GetMessage("CUSTOM_COMPLEX_EDITOR_DESCRIPTION"),
            "GetPropertyFieldHtml" => [__CLASS__, "GetPropertyFieldHtml"],
            "ConvertToDB" => [__CLASS__, "ConvertToDB"],
            "ConvertFromDB" => [__CLASS__, "ConvertFromDB"],
            "PrepareSettings" => [__CLASS__, "PrepareSettings"],
            "GetSettingsHTML" => [__CLASS__, "GetSettingsHTML"],
        ];
    }


    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        if ($value["VALUE"] == "" && $arProperty["DEFAULT_VALUE"] != "") {
            $value["VALUE"] = $arProperty["DEFAULT_VALUE"];
        }

        ob_start();

     
        CFileMan::AddHTMLEditorFrame(
            $strHTMLControlName["VALUE"],
            $value["VALUE"],
            $strHTMLControlName["DESCRIPTION"],
            "", 
            [
                'height' => $arProperty['USER_TYPE_SETTINGS']['EDITOR_HEIGHT'] ?: '200',
                'width' => '100%'
            ],
            "N",
            0,
            "",
            ""
        );

        return ob_get_clean();
    }

  
    public static function ConvertToDB($arProperty, $value)
    {
        if (is_array($value)) {
            $value["VALUE"] = htmlspecialcharsbx($value["VALUE"]);
        }
        return $value;
    }


    public static function ConvertFromDB($arProperty, $value)
    {
        if (is_array($value)) {
            $value["VALUE"] = htmlspecialchars_decode($value["VALUE"]);
        }
        return $value;
    }

   
    public static function PrepareSettings($arProperty)
    {
        $height = (int)($arProperty["USER_TYPE_SETTINGS"]["EDITOR_HEIGHT"] ?? 200);
        return ["EDITOR_HEIGHT" => $height > 0 ? $height : 200];
    }

 
    public static function GetSettingsHTML($arProperty, $strHTMLControlName, &$arPropertyFields)
    {
        $arPropertyFields = [
            "HIDE" => ["ROW_COUNT", "COL_COUNT"],
        ];

        $height = (int)($arProperty["USER_TYPE_SETTINGS"]["EDITOR_HEIGHT"] ?? 200);

        return '<tr>
            <td>' . GetMessage("CUSTOM_COMPLEX_EDITOR_HEIGHT") . ':</td>
            <td><input type="text" name="' . $strHTMLControlName["NAME"] . '[EDITOR_HEIGHT]" value="' . $height . '" size="10"></td>
        </tr>';
    }
}
