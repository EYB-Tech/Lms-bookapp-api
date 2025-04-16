<?php
// عرض معلومات PHP الأساسية
echo "<h2>معلومات PHP:</h2>";
echo "الإصدار: " . phpversion() . "<br>";
echo "المسار: " . php_ini_loaded_file() . "<br>";
echo "نوع الإصدار: " . php_sapi_name() . "<br>";

// عرض الإعدادات المحددة
echo "<h2>إعدادات PHP المهمة:</h2>";
echo "<table border='1'>";
echo "<tr><th>الإعداد</th><th>القيمة الحالية</th></tr>";

// إضافة الإعدادات التي تريد معرفة قيمها
$settings = [
    'display_errors'          => ini_get('display_errors'),
    'upload_max_filesize'     => ini_get('upload_max_filesize'),
    'post_max_size'           => ini_get('post_max_size'),
    'memory_limit'            => ini_get('memory_limit'),
    'allow_url_fopen'         => ini_get('allow_url_fopen'),
    'max_execution_time'      => ini_get('max_execution_time'),
    'max_input_time'          => ini_get('max_input_time'),
    'max_input_vars'          => ini_get('max_input_vars'),
    'session.gc_maxlifetime'  => ini_get('session.gc_maxlifetime'),
    'zlib.output_compression' => ini_get('zlib.output_compression'),
    'default_charset'         => ini_get('default_charset'),
    'opcache.enabled'         => ini_get('opcache.enable'), // تحقق من تفعيل Opcache
    'disable_functions'       => ini_get('disable_functions'),
    'file_uploads'            => ini_get('file_uploads'),
    'memory_limit'            => ini_get('memory_limit'),
];

foreach ($settings as $key => $value) {
    echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
}
echo "</table>";

// تحقق من المُمتلكات المُحمَّلة (مثل extension=system)
echo "<h2>المُمتلكات المُحمَّلة:</h2>";
echo "<pre>" . print_r(get_loaded_extensions(), true) . "</pre>";

// تحقق من إعدادات الجلسة
echo "<h2>إعدادات الجلسة:</h2>";
echo "مسار الجلسة: " . ini_get('session.save_path') . "<br>";
echo "حد الجلسة: " . ini_get('session.gc_maxlifetime') . " ثانية<br>";

// اختبار وظيفة معينة (مثل disk_free_space)
echo "<h2>اختبار وظيفة disk_free_space:</h2>";
if (function_exists('disk_free_space')) {
    echo "الوظيفة مُفعلة. مساحة متبقية في الجذر: " . disk_free_space('/') . " بايت.";
} else {
    echo "الوظيفة معطلة.";
}
?>