<?php
$kechidlinki="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$promokod="awardp";
$instagram="";
$telegram="";
$ioslink="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$androidlink="https://reffpa.com/L?tag=d_5444960m_45361c_&site=5444960&ad=45361";
$email="support@1xbet.com";
$indirlink="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$aviator="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$sport="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$livecasino="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$GatesofOlympus="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";
$SweetBonanza="https://reffpa.com/L?tag=d_5444960m_1599c_&site=5444960&ad=1599&r=registration";


//<?=$kechidlinki;

$xbet_langs = [
  'az' => ['href' => '/az', 'img' => 'imgs/az.png', 'alt' => 'Azərbaycanca', 'name' => 'Azərbaycanca'],
  'tr' => ['href' => '/tr', 'img' => 'imgs/tr.png', 'alt' => 'Türkçe', 'name' => 'Türkçe'],
  'en' => ['href' => '/en', 'img' => 'imgs/en.png', 'alt' => 'English', 'name' => 'English'],
  'uz' => ['href' => '/uz', 'img' => 'imgs/uz.png', 'alt' => "O'zbekcha", 'name' => "O'zbekcha"],
  'ru' => ['href' => '/', 'img' => 'imgs/ru.png', 'alt' => 'Русский', 'name' => 'Русский'],
];

function xbet_lang_items(string $currentLang): string {
  global $xbet_langs;
  $ariaLabels = [
    'az' => 'Dil',
    'tr' => 'Dil',
    'en' => 'Language',
    'uz' => 'Til',
    'ru' => 'Язык',
  ];
  $labelPrefix = $ariaLabels[$currentLang] ?? 'Language';
  $order = array_merge([$currentLang], array_values(array_diff(array_keys($xbet_langs), [$currentLang])));
  $items = [];
  foreach ($order as $code) {
    $lang = $xbet_langs[$code];
    $isActive = $code === $currentLang;
    $items[] = '<a href="' . $lang['href'] . '" class="xbet-lang__option' . ($isActive ? ' is-active' : '') . '" aria-label="' . $labelPrefix . ' ' . htmlspecialchars($lang['alt'], ENT_QUOTES) . '"' . ($isActive ? ' aria-current="page"' : '') . '><img src="' . $lang['img'] . '" alt="' . htmlspecialchars($lang['alt'], ENT_QUOTES) . '" width="20" height="20" decoding="async"><span>' . htmlspecialchars($lang['name'], ENT_QUOTES) . '</span></a>';
  }
  return implode('', $items);
}

function xbet_lang_switch(string $currentLang): string {
  global $xbet_langs;
  $current = $xbet_langs[$currentLang] ?? $xbet_langs['en'];
  return '<div class="xbet-lang xbet-lang--desktop"><button type="button" class="xbet-lang__btn js-menu-btn" aria-expanded="false"><img src="' . $current['img'] . '" alt="' . htmlspecialchars($current['alt'], ENT_QUOTES) . '" width="20" height="20" decoding="async"><span class="xbet-lang__current">' . htmlspecialchars($current['name'], ENT_QUOTES) . '</span><span class="xbet-lang__chevron">▾</span></button><div class="xbet-lang__list">' . xbet_lang_items($currentLang) . '</div></div>';
}

function xbet_lang_switch_mobile(string $currentLang): string {
  global $xbet_langs;
  $current = $xbet_langs[$currentLang] ?? $xbet_langs['en'];
  return '<div class="xbet-lang xbet-lang--mobile"><button type="button" class="xbet-lang__btn xbet-lang__btn--mobile js-menu-btn" aria-expanded="false"><img src="' . $current['img'] . '" alt="' . htmlspecialchars($current['alt'], ENT_QUOTES) . '" width="18" height="18" decoding="async"><span class="xbet-lang__current">' . htmlspecialchars($current['name'], ENT_QUOTES) . '</span><span class="xbet-lang__chevron">▾</span></button><div class="xbet-lang__list xbet-lang__list--mobile">' . xbet_lang_items($currentLang) . '</div></div>';
}

?>

