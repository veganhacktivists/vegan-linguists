<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                "code" => "ab",
                "name" => "Abkhaz",
                "native_name" => "аҧсуа"
            ],
            [
                "code" => "aa",
                "name" => "Afar",
                "native_name" => "Afaraf"
            ],
            [
                "code" => "af",
                "name" => "Afrikaans",
                "native_name" => "Afrikaans"
            ],
            [
                "code" => "ak",
                "name" => "Akan",
                "native_name" => "Akan"
            ],
            [
                "code" => "sq",
                "name" => "Albanian",
                "native_name" => "Shqip"
            ],
            [
                "code" => "am",
                "name" => "Amharic",
                "native_name" => "አማርኛ"
            ],
            [
                "code" => "ar",
                "name" => "Arabic",
                "native_name" => "العربية"
            ],
            [
                "code" => "an",
                "name" => "Aragonese",
                "native_name" => "Aragonés"
            ],
            [
                "code" => "hy",
                "name" => "Armenian",
                "native_name" => "Հայերեն"
            ],
            [
                "code" => "as",
                "name" => "Assamese",
                "native_name" => "অসমীয়া"
            ],
            [
                "code" => "av",
                "name" => "Avaric",
                "native_name" => "авар мацӀ, магӀарул мацӀ"
            ],
            [
                "code" => "ae",
                "name" => "Avestan",
                "native_name" => "avesta"
            ],
            [
                "code" => "ay",
                "name" => "Aymara",
                "native_name" => "aymar aru"
            ],
            [
                "code" => "az",
                "name" => "Azerbaijani",
                "native_name" => "azərbaycan dili"
            ],
            [
                "code" => "bm",
                "name" => "Bambara",
                "native_name" => "bamanankan"
            ],
            [
                "code" => "ba",
                "name" => "Bashkir",
                "native_name" => "башҡорт теле"
            ],
            [
                "code" => "eu",
                "name" => "Basque",
                "native_name" => "euskara, euskera"
            ],
            [
                "code" => "be",
                "name" => "Belarusian",
                "native_name" => "Беларуская"
            ],
            [
                "code" => "bn",
                "name" => "Bengali",
                "native_name" => "বাংলা"
            ],
            [
                "code" => "bh",
                "name" => "Bihari",
                "native_name" => "भोजपुरी"
            ],
            [
                "code" => "bi",
                "name" => "Bislama",
                "native_name" => "Bislama"
            ],
            [
                "code" => "bs",
                "name" => "Bosnian",
                "native_name" => "bosanski jezik"
            ],
            [
                "code" => "br",
                "name" => "Breton",
                "native_name" => "brezhoneg"
            ],
            [
                "code" => "bg",
                "name" => "Bulgarian",
                "native_name" => "български език"
            ],
            [
                "code" => "my",
                "name" => "Burmese",
                "native_name" => "ဗမာစာ"
            ],
            [
                "code" => "ca",
                "name" => "Catalan; Valencian",
                "native_name" => "Català"
            ],
            [
                "code" => "ch",
                "name" => "Chamorro",
                "native_name" => "Chamoru"
            ],
            [
                "code" => "ce",
                "name" => "Chechen",
                "native_name" => "нохчийн мотт"
            ],
            [
                "code" => "ny",
                "name" => "Chichewa; Chewa; Nyanja",
                "native_name" => "chiCheŵa, chinyanja"
            ],
            [
                "code" => "zh",
                "name" => "Chinese",
                "native_name" => "中文 (Zhōngwén), 汉语, 漢語"
            ],
            [
                "code" => "cv",
                "name" => "Chuvash",
                "native_name" => "чӑваш чӗлхи"
            ],
            [
                "code" => "kw",
                "name" => "Cornish",
                "native_name" => "Kernewek"
            ],
            [
                "code" => "co",
                "name" => "Corsican",
                "native_name" => "corsu, lingua corsa"
            ],
            [
                "code" => "cr",
                "name" => "Cree",
                "native_name" => "ᓀᐦᐃᔭᐍᐏᐣ"
            ],
            [
                "code" => "hr",
                "name" => "Croatian",
                "native_name" => "hrvatski"
            ],
            [
                "code" => "cs",
                "name" => "Czech",
                "native_name" => "česky, čeština"
            ],
            [
                "code" => "da",
                "name" => "Danish",
                "native_name" => "dansk"
            ],
            [
                "code" => "dv",
                "name" => "Divehi; Dhivehi; Maldivian;",
                "native_name" => "ދިވެހި"
            ],
            [
                "code" => "nl",
                "name" => "Dutch",
                "native_name" => "Nederlands, Vlaams"
            ],
            [
                "code" => "en",
                "name" => "English",
                "native_name" => "English"
            ],
            [
                "code" => "eo",
                "name" => "Esperanto",
                "native_name" => "Esperanto"
            ],
            [
                "code" => "et",
                "name" => "Estonian",
                "native_name" => "eesti, eesti keel"
            ],
            [
                "code" => "ee",
                "name" => "Ewe",
                "native_name" => "Eʋegbe"
            ],
            [
                "code" => "fo",
                "name" => "Faroese",
                "native_name" => "føroyskt"
            ],
            [
                "code" => "fj",
                "name" => "Fijian",
                "native_name" => "vosa Vakaviti"
            ],
            [
                "code" => "fi",
                "name" => "Finnish",
                "native_name" => "suomi, suomen kieli"
            ],
            [
                "code" => "fr",
                "name" => "French",
                "native_name" => "français, langue française"
            ],
            [
                "code" => "ff",
                "name" => "Fula; Fulah; Pulaar; Pular",
                "native_name" => "Fulfulde, Pulaar, Pular"
            ],
            [
                "code" => "gl",
                "name" => "Galician",
                "native_name" => "Galego"
            ],
            [
                "code" => "ka",
                "name" => "Georgian",
                "native_name" => "ქართული"
            ],
            [
                "code" => "de",
                "name" => "German",
                "native_name" => "Deutsch"
            ],
            [
                "code" => "el",
                "name" => "Greek, Modern",
                "native_name" => "Ελληνικά"
            ],
            [
                "code" => "gn",
                "name" => "Guaraní",
                "native_name" => "Avañeẽ"
            ],
            [
                "code" => "gu",
                "name" => "Gujarati",
                "native_name" => "ગુજરાતી"
            ],
            [
                "code" => "ht",
                "name" => "Haitian; Haitian Creole",
                "native_name" => "Kreyòl ayisyen"
            ],
            [
                "code" => "ha",
                "name" => "Hausa",
                "native_name" => "Hausa, هَوُسَ"
            ],
            [
                "code" => "he",
                "name" => "Hebrew",
                "native_name" => "עברית"
            ],
            [
                "code" => "hz",
                "name" => "Herero",
                "native_name" => "Otjiherero"
            ],
            [
                "code" => "hi",
                "name" => "Hindi",
                "native_name" => "हिन्दी, हिंदी"
            ],
            [
                "code" => "ho",
                "name" => "Hiri Motu",
                "native_name" => "Hiri Motu"
            ],
            [
                "code" => "hu",
                "name" => "Hungarian",
                "native_name" => "Magyar"
            ],
            [
                "code" => "ia",
                "name" => "Interlingua",
                "native_name" => "Interlingua"
            ],
            [
                "code" => "id",
                "name" => "Indonesian",
                "native_name" => "Bahasa Indonesia"
            ],
            [
                "code" => "ie",
                "name" => "Interlingue",
                "native_name" => "Originally called Occidental; then Interlingue after WWII"
            ],
            [
                "code" => "ga",
                "name" => "Irish",
                "native_name" => "Gaeilge"
            ],
            [
                "code" => "ig",
                "name" => "Igbo",
                "native_name" => "Asụsụ Igbo"
            ],
            [
                "code" => "ik",
                "name" => "Inupiaq",
                "native_name" => "Iñupiaq, Iñupiatun"
            ],
            [
                "code" => "io",
                "name" => "Ido",
                "native_name" => "Ido"
            ],
            [
                "code" => "is",
                "name" => "Icelandic",
                "native_name" => "Íslenska"
            ],
            [
                "code" => "it",
                "name" => "Italian",
                "native_name" => "Italiano"
            ],
            [
                "code" => "iu",
                "name" => "Inuktitut",
                "native_name" => "ᐃᓄᒃᑎᑐᑦ"
            ],
            [
                "code" => "ja",
                "name" => "Japanese",
                "native_name" => "日本語 (にほんご／にっぽんご)"
            ],
            [
                "code" => "jv",
                "name" => "Javanese",
                "native_name" => "basa Jawa"
            ],
            [
                "code" => "kl",
                "name" => "Kalaallisut, Greenlandic",
                "native_name" => "kalaallisut, kalaallit oqaasii"
            ],
            [
                "code" => "kn",
                "name" => "Kannada",
                "native_name" => "ಕನ್ನಡ"
            ],
            [
                "code" => "kr",
                "name" => "Kanuri",
                "native_name" => "Kanuri"
            ],
            [
                "code" => "ks",
                "name" => "Kashmiri",
                "native_name" => "कश्मीरी, كشميري‎"
            ],
            [
                "code" => "kk",
                "name" => "Kazakh",
                "native_name" => "Қазақ тілі"
            ],
            [
                "code" => "km",
                "name" => "Khmer",
                "native_name" => "ភាសាខ្មែរ"
            ],
            [
                "code" => "ki",
                "name" => "Kikuyu, Gikuyu",
                "native_name" => "Gĩkũyũ"
            ],
            [
                "code" => "rw",
                "name" => "Kinyarwanda",
                "native_name" => "Ikinyarwanda"
            ],
            [
                "code" => "ky",
                "name" => "Kirghiz, Kyrgyz",
                "native_name" => "кыргыз тили"
            ],
            [
                "code" => "kv",
                "name" => "Komi",
                "native_name" => "коми кыв"
            ],
            [
                "code" => "kg",
                "name" => "Kongo",
                "native_name" => "KiKongo"
            ],
            [
                "code" => "ko",
                "name" => "Korean",
                "native_name" => "한국어 (韓國語), 조선말 (朝鮮語)"
            ],
            [
                "code" => "ku",
                "name" => "Kurdish",
                "native_name" => "Kurdî, كوردی‎"
            ],
            [
                "code" => "kj",
                "name" => "Kwanyama, Kuanyama",
                "native_name" => "Kuanyama"
            ],
            [
                "code" => "la",
                "name" => "Latin",
                "native_name" => "latine, lingua latina"
            ],
            [
                "code" => "lb",
                "name" => "Luxembourgish, Letzeburgesch",
                "native_name" => "Lëtzebuergesch"
            ],
            [
                "code" => "lg",
                "name" => "Luganda",
                "native_name" => "Luganda"
            ],
            [
                "code" => "li",
                "name" => "Limburgish, Limburgan, Limburger",
                "native_name" => "Limburgs"
            ],
            [
                "code" => "ln",
                "name" => "Lingala",
                "native_name" => "Lingála"
            ],
            [
                "code" => "lo",
                "name" => "Lao",
                "native_name" => "ພາສາລາວ"
            ],
            [
                "code" => "lt",
                "name" => "Lithuanian",
                "native_name" => "lietuvių kalba"
            ],
            [
                "code" => "lv",
                "name" => "Latvian",
                "native_name" => "latviešu valoda"
            ],
            [
                "code" => "gv",
                "name" => "Manx",
                "native_name" => "Gaelg, Gailck"
            ],
            [
                "code" => "mk",
                "name" => "Macedonian",
                "native_name" => "македонски јазик"
            ],
            [
                "code" => "mg",
                "name" => "Malagasy",
                "native_name" => "Malagasy fiteny"
            ],
            [
                "code" => "ms",
                "name" => "Malay",
                "native_name" => "bahasa Melayu, بهاس ملايو‎"
            ],
            [
                "code" => "ml",
                "name" => "Malayalam",
                "native_name" => "മലയാളം"
            ],
            [
                "code" => "mt",
                "name" => "Maltese",
                "native_name" => "Malti"
            ],
            [
                "code" => "mi",
                "name" => "Māori",
                "native_name" => "te reo Māori"
            ],
            [
                "code" => "mr",
                "name" => "Marathi (Marāṭhī)",
                "native_name" => "मराठी"
            ],
            [
                "code" => "mh",
                "name" => "Marshallese",
                "native_name" => "Kajin M̧ajeļ"
            ],
            [
                "code" => "mn",
                "name" => "Mongolian",
                "native_name" => "монгол"
            ],
            [
                "code" => "na",
                "name" => "Nauru",
                "native_name" => "Ekakairũ Naoero"
            ],
            [
                "code" => "nv",
                "name" => "Navajo, Navaho",
                "native_name" => "Diné bizaad, Dinékʼehǰí"
            ],
            [
                "code" => "nb",
                "name" => "Norwegian Bokmål",
                "native_name" => "Norsk bokmål"
            ],
            [
                "code" => "nd",
                "name" => "North Ndebele",
                "native_name" => "isiNdebele"
            ],
            [
                "code" => "ne",
                "name" => "Nepali",
                "native_name" => "नेपाली"
            ],
            [
                "code" => "ng",
                "name" => "Ndonga",
                "native_name" => "Owambo"
            ],
            [
                "code" => "nn",
                "name" => "Norwegian Nynorsk",
                "native_name" => "Norsk nynorsk"
            ],
            [
                "code" => "no",
                "name" => "Norwegian",
                "native_name" => "Norsk"
            ],
            [
                "code" => "ii",
                "name" => "Nuosu",
                "native_name" => "ꆈꌠ꒿ Nuosuhxop"
            ],
            [
                "code" => "nr",
                "name" => "South Ndebele",
                "native_name" => "isiNdebele"
            ],
            [
                "code" => "oc",
                "name" => "Occitan",
                "native_name" => "Occitan"
            ],
            [
                "code" => "oj",
                "name" => "Ojibwe, Ojibwa",
                "native_name" => "ᐊᓂᔑᓈᐯᒧᐎᓐ"
            ],
            [
                "code" => "cu",
                "name" => "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic",
                "native_name" => "ѩзыкъ словѣньскъ"
            ],
            [
                "code" => "om",
                "name" => "Oromo",
                "native_name" => "Afaan Oromoo"
            ],
            [
                "code" => "or",
                "name" => "Oriya",
                "native_name" => "ଓଡ଼ିଆ"
            ],
            [
                "code" => "os",
                "name" => "Ossetian, Ossetic",
                "native_name" => "ирон æвзаг"
            ],
            [
                "code" => "pa",
                "name" => "Panjabi, Punjabi",
                "native_name" => "ਪੰਜਾਬੀ, پنجابی‎"
            ],
            [
                "code" => "pi",
                "name" => "Pāli",
                "native_name" => "पाऴि"
            ],
            [
                "code" => "fa",
                "name" => "Persian",
                "native_name" => "فارسی"
            ],
            [
                "code" => "pl",
                "name" => "Polish",
                "native_name" => "polski"
            ],
            [
                "code" => "ps",
                "name" => "Pashto, Pushto",
                "native_name" => "پښتو"
            ],
            [
                "code" => "pt",
                "name" => "Portuguese",
                "native_name" => "Português"
            ],
            [
                "code" => "qu",
                "name" => "Quechua",
                "native_name" => "Runa Simi, Kichwa"
            ],
            [
                "code" => "rm",
                "name" => "Romansh",
                "native_name" => "rumantsch grischun"
            ],
            [
                "code" => "rn",
                "name" => "Kirundi",
                "native_name" => "kiRundi"
            ],
            [
                "code" => "ro",
                "name" => "Romanian, Moldavian, Moldovan",
                "native_name" => "română"
            ],
            [
                "code" => "ru",
                "name" => "Russian",
                "native_name" => "русский язык"
            ],
            [
                "code" => "sa",
                "name" => "Sanskrit (Saṁskṛta)",
                "native_name" => "संस्कृतम्"
            ],
            [
                "code" => "sc",
                "name" => "Sardinian",
                "native_name" => "sardu"
            ],
            [
                "code" => "sd",
                "name" => "Sindhi",
                "native_name" => "सिन्धी, سنڌي، سندھی‎"
            ],
            [
                "code" => "se",
                "name" => "Northern Sami",
                "native_name" => "Davvisámegiella"
            ],
            [
                "code" => "sm",
                "name" => "Samoan",
                "native_name" => "gagana faa Samoa"
            ],
            [
                "code" => "sg",
                "name" => "Sango",
                "native_name" => "yângâ tî sängö"
            ],
            [
                "code" => "sr",
                "name" => "Serbian",
                "native_name" => "српски језик"
            ],
            [
                "code" => "gd",
                "name" => "Scottish Gaelic; Gaelic",
                "native_name" => "Gàidhlig"
            ],
            [
                "code" => "sn",
                "name" => "Shona",
                "native_name" => "chiShona"
            ],
            [
                "code" => "si",
                "name" => "Sinhala, Sinhalese",
                "native_name" => "සිංහල"
            ],
            [
                "code" => "sk",
                "name" => "Slovak",
                "native_name" => "slovenčina"
            ],
            [
                "code" => "sl",
                "name" => "Slovene",
                "native_name" => "slovenščina"
            ],
            [
                "code" => "so",
                "name" => "Somali",
                "native_name" => "Soomaaliga, af Soomaali"
            ],
            [
                "code" => "st",
                "name" => "Southern Sotho",
                "native_name" => "Sesotho"
            ],
            [
                "code" => "es",
                "name" => "Spanish; Castilian",
                "native_name" => "español, castellano"
            ],
            [
                "code" => "su",
                "name" => "Sundanese",
                "native_name" => "Basa Sunda"
            ],
            [
                "code" => "sw",
                "name" => "Swahili",
                "native_name" => "Kiswahili"
            ],
            [
                "code" => "ss",
                "name" => "Swati",
                "native_name" => "SiSwati"
            ],
            [
                "code" => "sv",
                "name" => "Swedish",
                "native_name" => "svenska"
            ],
            [
                "code" => "ta",
                "name" => "Tamil",
                "native_name" => "தமிழ்"
            ],
            [
                "code" => "te",
                "name" => "Telugu",
                "native_name" => "తెలుగు"
            ],
            [
                "code" => "tg",
                "name" => "Tajik",
                "native_name" => "тоҷикӣ, toğikī, تاجیکی‎"
            ],
            [
                "code" => "th",
                "name" => "Thai",
                "native_name" => "ไทย"
            ],
            [
                "code" => "ti",
                "name" => "Tigrinya",
                "native_name" => "ትግርኛ"
            ],
            [
                "code" => "bo",
                "name" => "Tibetan Standard, Tibetan, Central",
                "native_name" => "བོད་ཡིག"
            ],
            [
                "code" => "tk",
                "name" => "Turkmen",
                "native_name" => "Türkmen, Түркмен"
            ],
            [
                "code" => "tl",
                "name" => "Tagalog",
                "native_name" => "Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔"
            ],
            [
                "code" => "tn",
                "name" => "Tswana",
                "native_name" => "Setswana"
            ],
            [
                "code" => "to",
                "name" => "Tonga (Tonga Islands)",
                "native_name" => "faka Tonga"
            ],
            [
                "code" => "tr",
                "name" => "Turkish",
                "native_name" => "Türkçe"
            ],
            [
                "code" => "ts",
                "name" => "Tsonga",
                "native_name" => "Xitsonga"
            ],
            [
                "code" => "tt",
                "name" => "Tatar",
                "native_name" => "татарча, tatarça, تاتارچا‎"
            ],
            [
                "code" => "tw",
                "name" => "Twi",
                "native_name" => "Twi"
            ],
            [
                "code" => "ty",
                "name" => "Tahitian",
                "native_name" => "Reo Tahiti"
            ],
            [
                "code" => "ug",
                "name" => "Uighur, Uyghur",
                "native_name" => "Uyƣurqə, ئۇيغۇرچە‎"
            ],
            [
                "code" => "uk",
                "name" => "Ukrainian",
                "native_name" => "українська"
            ],
            [
                "code" => "ur",
                "name" => "Urdu",
                "native_name" => "اردو"
            ],
            [
                "code" => "uz",
                "name" => "Uzbek",
                "native_name" => "zbek, Ўзбек, أۇزبېك‎"
            ],
            [
                "code" => "ve",
                "name" => "Venda",
                "native_name" => "Tshivenḓa"
            ],
            [
                "code" => "vi",
                "name" => "Vietnamese",
                "native_name" => "Tiếng Việt"
            ],
            [
                "code" => "vo",
                "name" => "Volapük",
                "native_name" => "Volapük"
            ],
            [
                "code" => "wa",
                "name" => "Walloon",
                "native_name" => "Walon"
            ],
            [
                "code" => "cy",
                "name" => "Welsh",
                "native_name" => "Cymraeg"
            ],
            [
                "code" => "wo",
                "name" => "Wolof",
                "native_name" => "Wollof"
            ],
            [
                "code" => "fy",
                "name" => "Western Frisian",
                "native_name" => "Frysk"
            ],
            [
                "code" => "xh",
                "name" => "Xhosa",
                "native_name" => "isiXhosa"
            ],
            [
                "code" => "yi",
                "name" => "Yiddish",
                "native_name" => "ייִדיש"
            ],
            [
                "code" => "yo",
                "name" => "Yoruba",
                "native_name" => "Yorùbá"
            ],
            [
                "code" => "za",
                "name" => "Zhuang, Chuang",
                "native_name" => "Saɯ cueŋƅ, Saw cuengh"
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
