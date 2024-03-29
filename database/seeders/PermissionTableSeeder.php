<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            
            'الفاواتير',
            'قائمة_الفواتير',
            'الفواتير_المدفوعة',
            'الفواتير_المدفوعة_جزئيآ',
            'الفواتير_الغير_المدفوعة',
            'أرشيف_الفواتير',
            'التقارير',
            'تقرير_الفواتير',
            'تقرير_العملاء',
            'المستخدمين',
            'قائمة_المستخدمين',
            'صلاحيات_المستخدمين',
            'الأعدادات',
            'المنتجات',
            'الاقسام',


            'أضافة_فاتوره',
            'تصدير_EXCel',
            'حذف_الفاتورة',
            'تغيير_حاله_الدفع',
            'تعديل_الفاتوره',
            'أضافه_مرفق',
            'حذف_المرفق',
            'ارشفه_الفواتير',

            'أضافه_مستخدم',
            'حذف_مستخدم',
            'تعديل_مستخدم',

           'عرض_صلاحيه',
           'أضافة_صلاحية',
           'تعديل_صلاحية',
           'حذف_صلاحية',


 

            'أضافه_منتج',
            'تعديل_منتج',
            'جذف_منتج',

            'أضافة_قسم',
            'تعديل_قسم',
            'حذف_قسم',

           


        ];
     
        foreach ($permissions as $permission) {
             Permission::updateOrCreate(['name' => $permission]);
        }
    }
}