<?php
// 获取当前时间
$currentHour = (int)date('H');

// 检查当前时间是否在 12 点到 23 点之间
if ($currentHour < 12 || $currentHour >= 23) {
    echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24; margin: 20px; text-align: center;'>当前时间不在可提交范围内，请在每天 12 点至 23 点之间提交。</div>";
    exit;
}

// 获取用户 IP 地址
$ip = $_SERVER['REMOTE_ADDR'];

// 读取存储错误次数的文件
$file = '1.txt';
if (file_exists($file)) {
    $data = file_get_contents($file);
    $ipData = unserialize($data);
} else {
    $ipData = [];
}

// 如果当前 IP 已经存在错误记录
if (isset($ipData[$ip])) {
    // 如果错误次数达到 10 次
    if ($ipData[$ip] >= 10) {
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24; margin: 20px; text-align: center;'>您今天输入密码错误次数已达上限，请明天再试。</div>";
        exit;
    }
}

// 处理密码验证逻辑
// 过滤和清理用户输入的密码
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// 假设正确的密码
$correctPassword1 = '1234';
$correctPassword2 = '12345';

// 验证密码
if ($password === $correctPassword1) {
    header("Location: https://www.baidu.com");
    exit;
} elseif ($password === $correctPassword2) {
    header("Location: https://www.douyin.com");
    exit;
} else {
    // 密码错误，错误次数加 1
    if (!isset($ipData[$ip])) {
        $ipData[$ip] = 1;
    } else {
        $ipData[$ip]++;
    }

    // 将更新后的错误次数信息保存到文件
    file_put_contents($file, serialize($ipData));

    echo "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24; margin: 20px; text-align: center;'>密码错误，请重新输入。</div>";
}
?>