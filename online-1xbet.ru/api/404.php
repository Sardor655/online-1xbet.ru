<?php
http_response_code(404);

$supported = ['en', 'az', 'tr', 'uz'];
$defaultLang = 'ru';

$originalPath = $_SERVER['REDIRECT_URL'] ?? $_SERVER['REDIRECT_REQUEST_URI'] ?? ($_SERVER['REQUEST_URI'] ?? '/');
$originalPath = parse_url($originalPath, PHP_URL_PATH) ?: '/';
$parts = array_values(array_filter(explode('/', trim($originalPath, '/'))));
$first = $parts[0] ?? '';
$lang = $defaultLang;
if (in_array($first, $supported, true)) {
    $lang = $first;
} elseif ($first === 'ru') {
    $lang = 'ru';
}

$pages = [
    'ru' => 'index.php',
    'en' => 'en.php',
    'az' => 'az.php',
    'tr' => 'tr.php',
    'uz' => 'uz.php',
];

$texts = [
    'ru' => [
        'html_lang' => 'ru',
        'title' => 'Страница не найдена | 1xBET',
        'h1' => 'Страница не найдена',
        'text' => 'Извините, страница, которую вы ищете, не существует или адрес был введён неверно.',
        'button' => 'Вернуться на главную',
        'home' => '/',
    ],
    'en' => [
        'html_lang' => 'en',
        'title' => 'Page not found | 1xBET',
        'h1' => 'Page not found',
        'text' => 'Sorry, the page you are looking for does not exist or the address was entered incorrectly.',
        'button' => 'Back to home',
        'home' => '/en',
    ],
    'az' => [
        'html_lang' => 'az',
        'title' => 'Səhifə tapılmadı | 1xBET',
        'h1' => 'Səhifə tapılmadı',
        'text' => 'Bağışlayın, axtardığınız səhifə mövcud deyil və ya ünvan səhv yazılıb.',
        'button' => 'Ana səhifəyə qayıt',
        'home' => '/az',
    ],
    'tr' => [
        'html_lang' => 'tr',
        'title' => 'Sayfa bulunamadı | 1xBET',
        'h1' => 'Sayfa bulunamadı',
        'text' => 'Üzgünüz, aradığınız sayfa mevcut değil veya adres yanlış yazılmış olabilir.',
        'button' => 'Ana sayfaya dön',
        'home' => '/tr',
    ],
    'uz' => [
        'html_lang' => 'uz',
        'title' => 'Sahifa topilmadi | 1xBET',
        'h1' => 'Sahifa topilmadi',
        'text' => 'Kechirasiz, siz qidirayotgan sahifa mavjud emas yoki manzil notoʻgʻri kiritilgan.',
        'button' => 'Bosh sahifaga qaytish',
        'home' => '/uz',
    ],
];

$t = $texts[$lang] ?? $texts[$defaultLang];
$templateFile = __DIR__ . '/' . ($pages[$lang] ?? $pages[$defaultLang]);

ob_start();
if (is_file($templateFile)) {
    include $templateFile;
}
$templateHtml = ob_get_clean();

function xbet_404_abs_paths(string $html): string {
    $replacements = [
        'href="./assets/' => 'href="/assets/',
        "href='./assets/" => "href='/assets/",
        'src="./assets/' => 'src="/assets/',
        "src='./assets/" => "src='/assets/",
        'content="./assets/' => 'content="/assets/',
        "content='./assets/" => "content='/assets/",
        'href="assets/' => 'href="/assets/',
        "href='assets/" => "href='/assets/",
        'src="assets/' => 'src="/assets/',
        "src='assets/" => "src='/assets/",
        'content="assets/' => 'content="/assets/',
        "content='assets/" => "content='/assets/",
        'src="imgs/' => 'src="/imgs/',
        "src='imgs/" => "src='/imgs/",
        'href="imgs/' => 'href="/imgs/',
        "href='imgs/" => "href='/imgs/",
        'content="imgs/' => 'content="/imgs/',
        "content='imgs/" => "content='/imgs/",
    ];
    return strtr($html, $replacements);
}

function xbet_404_prepare_head(string $top, array $t): string {
    $top = preg_replace('/<html\s+lang="[^"]*"/i', '<html lang="' . htmlspecialchars($t['html_lang'], ENT_QUOTES, 'UTF-8') . '"', $top, 1);
    $top = preg_replace('/<title>.*?<\/title>/is', '<title>' . htmlspecialchars($t['title'], ENT_QUOTES, 'UTF-8') . '</title>', $top, 1);
    if (preg_match('/<meta\s+name="robots"[^>]*>/i', $top)) {
        $top = preg_replace('/<meta\s+name="robots"[^>]*>/i', '<meta name="robots" content="noindex, follow">', $top, 1);
    } else {
        $top = preg_replace('/<meta\s+charset="[^>]+>/i', '$0' . "\n<meta name=\"robots\" content=\"noindex, follow\">", $top, 1);
    }
    $top = preg_replace('/<meta\s+name="description"[^>]*>/i', '<meta name="description" content="' . htmlspecialchars($t['text'], ENT_QUOTES, 'UTF-8') . '">', $top, 1);
    $top = preg_replace('/<meta\s+property="og:title"[^>]*>/i', '<meta property="og:title" content="' . htmlspecialchars($t['title'], ENT_QUOTES, 'UTF-8') . '">', $top, 1);
    $top = preg_replace('/<meta\s+property="og:description"[^>]*>/i', '<meta property="og:description" content="' . htmlspecialchars($t['text'], ENT_QUOTES, 'UTF-8') . '">', $top, 1);
    $top = preg_replace('/<meta\s+name="twitter:title"[^>]*>/i', '<meta name="twitter:title" content="' . htmlspecialchars($t['title'], ENT_QUOTES, 'UTF-8') . '">', $top, 1);
    $top = preg_replace('/<meta\s+name="twitter:description"[^>]*>/i', '<meta name="twitter:description" content="' . htmlspecialchars($t['text'], ENT_QUOTES, 'UTF-8') . '">', $top, 1);
    $top = preg_replace('/<link\s+rel="canonical"[^>]*>\s*/i', '', $top);
    $top = preg_replace('/<link\s+rel="alternate"[^>]*>\s*/i', '', $top);
    $top = preg_replace('/<script\s+type="application\/ld\+json"[^>]*>.*?<\/script>\s*/is', '', $top);
    return xbet_404_abs_paths($top);
}

$headerEnd = stripos($templateHtml, '</header>');
if ($headerEnd === false) {
    echo '<!DOCTYPE html><html lang="' . htmlspecialchars($t['html_lang'], ENT_QUOTES, 'UTF-8') . '"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="robots" content="noindex, follow"><title>' . htmlspecialchars($t['title'], ENT_QUOTES, 'UTF-8') . '</title><link rel="stylesheet" href="/assets/css/main.css?v=13"></head><body><main>';
} else {
    $top = substr($templateHtml, 0, $headerEnd + strlen('</header>'));
    echo xbet_404_prepare_head($top, $t);
}
?>
<section class="custom-404-page" style="background:#fff;color:#111;min-height:calc(100vh - 96px);padding:80px 20px;display:flex;align-items:center;justify-content:center;text-align:center;">
  <div style="max-width:720px;margin:0 auto;">
    <div style="font-size:92px;line-height:1;font-weight:800;color:#1D4268;margin-bottom:18px;">404</div>
    <h1 style="margin:0 0 16px;font-size:36px;line-height:1.2;color:#111;font-weight:800;"><?php echo htmlspecialchars($t['h1'], ENT_QUOTES, 'UTF-8'); ?></h1>
    <p style="margin:0 auto 28px;font-size:18px;line-height:1.6;color:#222;max-width:620px;"><?php echo htmlspecialchars($t['text'], ENT_QUOTES, 'UTF-8'); ?></p>
    <a href="<?php echo htmlspecialchars($t['home'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-green" style="display:inline-flex;align-items:center;justify-content:center;min-height:48px;padding:14px 28px;border-radius:10px;background:#7EAC2F;border:1px solid #7EAC2F;color:#fff !important;font-weight:700;text-decoration:none;box-shadow:none;"><?php echo htmlspecialchars($t['button'], ENT_QUOTES, 'UTF-8'); ?></a>
  </div>
</section>
</main>
<script src="/assets/js/main.js?v=2" type="module"></script>
<script src="/assets/js/link.js?v=2"></script>
</body>
</html>
