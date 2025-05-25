<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class FilesController extends Controller
{
    // public function readAndEditMyFile(){
    //     $filePath = public_path('word.docx');
    
    //     if (!file_exists($filePath)) {
    //         return 'File does not exist.';
    //     }
    
    //     // تحميل ملف docx
    //     $phpWord = IOFactory::load($filePath);
    
    //     // تعديل النص في الأقسام
    //     foreach ($phpWord->getSections() as $section) {
    //         $newElements = [];
    
    //         foreach ($section->getElements() as $element) {
    //             // تحقق إذا كان العنصر يمكن الحصول على نصه
    //             if (method_exists($element, 'getText')) {
    //                 $originalText = $element->getText();
    
    //                 // تعديل النص أو استبداله
    //                 $newText = str_replace('النص القديم', 'النص الجديد', $originalText);
    
    //                 // إنشاء عنصر نصي جديد مع النص المعدل
    //                 $newElement = new \PhpOffice\PhpWord\Element\Text($newText);
    //                 $newElements[] = $newElement;
    //             } else {
    //                 // الاحتفاظ بالعناصر التي لا يمكن تعديلها كما هي
    //                 $newElements[] = $element;
    //             }
    //         }
    
    //         // إعادة تعيين العناصر في القسم
    //         $section->setElements($newElements);
    //     }
    
    //     // حفظ الملف المعدل إلى ملف جديد أو استبدال الملف القديم
    //     $newFilePath = public_path('edited_word.docx');
    //     $phpWord->save($newFilePath, 'Word2007');
    
    //     return "File edited and saved as edited_word.docx";
    // }
    public function readAndEditMyFile(){
        $filePath = public_path('edited_word.docx');

        if (!file_exists($filePath)) {
            return 'File does not exist.';
        }
    
        $phpWord = IOFactory::load($filePath);
        $text = '';
    
        // استخراج النص من جميع الأقسام
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $content = $element->getText();
    
                    // إذا كانت النتيجة مصفوفة، نجمع العناصر النصية معًا
                    if (is_array($content)) {
                        $text .= implode("\n", $content) . "\n";
                    } else {
                        $text .= $content . "\n";
                    }
                }
            }
        }
    
        // return nl2br($text); 
        return view('admin.docs.readfile' , compact('text'));
    }
}
