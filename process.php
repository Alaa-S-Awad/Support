<?php
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'حدث خطأ في إرسال الطلب. يرجى التأكد من ملء جميع الحقول.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التأكد من أن جميع الحقول المطلوبة موجودة
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['service']) && isset($_POST['details'])) {
        
        $to = "your-email@example.com"; // **استبدل هذا ببريدك الإلكتروني**
        $subject = "طلب خدمة تقنية جديد من: " . $_POST['name'];
        
        // بناء محتوى الرسالة
        $body = "تم استلام طلب خدمة جديد:\n\n";
        $body .= "الاسم الكامل: " . $_POST['name'] . "\n";
        $body .= "البريد الإلكتروني: " . $_POST['email'] . "\n";
        $body .= "رقم الهاتف: " . (isset($_POST['phone']) ? $_POST['phone'] : 'غير متوفر') . "\n";
        $body .= "نوع الخدمة المطلوبة: " . $_POST['service'] . "\n\n";
        $body .= "تفاصيل الطلب:\n" . $_POST['details'] . "\n";
        
        // Headers للبريد الإلكتروني
        $headers = "From: webmaster@yourdomain.com" . "\r\n"; // **استبدل هذا ببريدك الإلكتروني الخاص بالنطاق**
        $headers .= "Reply-To: " . $_POST['email'] . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // إرسال البريد الإلكتروني
        if (mail($to, $subject, $body, $headers)) {
            $response['status'] = 'success';
            $response['message'] = 'تم إرسال طلبك بنجاح! سيتم التواصل معك قريبًا.';
        } else {
            $response['message'] = 'فشل إرسال البريد الإلكتروني. يرجى المحاولة لاحقًا.';
        }
    }
}

echo json_encode($response);
?>
