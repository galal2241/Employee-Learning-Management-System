<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class CertificateController extends Controller
{
    public function generate(Request $request, $employeeId, $courseId)
    {
        // بيانات مؤقتة للاختبار (هتستبدلها بالبيانات الحقيقية من الداتابيز)
        $data = [
            'employee_name' => 'John Doe', // استبدل باسم الموظف من الداتابيز
            'course_name' => 'Laravel Advanced Course', // استبدل باسم الدورة
            'completion_date' => now()->format('Y-m-d'), // استبدل بتاريخ الإكمال
        ];

        // إنشاء كائن mPDF
        $mpdf = new Mpdf();

        // تحميل الـ Blade Template كـ HTML
        $html = view('certificates.certificate', $data)->render();

        // كتابة الـ HTML إلى الـ PDF
        $mpdf->WriteHTML($html);

        // إرجاع الـ PDF كملف للتحميل
        return $mpdf->Output('certificate.pdf', 'D'); // 'D' تعني تحميل الملف
    }
}