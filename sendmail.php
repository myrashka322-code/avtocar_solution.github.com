<?php
$to = "avtocar_solution@ukr.net";
$subject = "Нова заявка з сайту AvtoCar Solution";

$name = $_POST['name'];
$phone = $_POST['phone'];
$vin = $_POST['vin'];
$description = $_POST['description'];

$message = "Ім'я: $name\nТелефон: $phone\nVIN: $vin\n\nОпис деталі:\n$description";

$headers = "From: no-reply@yourdomain.com\r\n";
$headers .= "Reply-To: $phone\r\n";

if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $file_tmp = $_FILES['photo']['tmp_name'];
    $file_name = $_FILES['photo']['name'];
    $file_data = chunk_split(base64_encode(file_get_contents($file_tmp)));
    $boundary = md5(time());

    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";

    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $body .= $message."\r\n";
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"$file_name\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
    $body .= $file_data."\r\n";
    $body .= "--$boundary--";

    mail($to, $subject, $body, $headers);
} else {
    mail($to, $subject, $message, $headers);
}

echo "Заявка успішно відправлена!";
?>