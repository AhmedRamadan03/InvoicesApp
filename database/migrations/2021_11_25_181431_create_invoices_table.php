<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number');   // رقم الفاتوره
            $table->date('invoice_Date');       // تاريخ الفاتوره
            $table->date('due_Date');           // تاريخ استحقاق الفاتوره
            $table->string('product');          // العناصر
            $table->unsignedBigInteger('cat_id');          // القسم
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->decimal('amount_collection', 8, 2);
            $table->decimal('amount_Commission', 8, 2);
            $table->decimal('discount', 8, 2);         // الخصم
            $table->string('rate_vat');         // نسبه الضريبه
            $table->decimal('value_vat', 8, 2); // قيمه الضريبه
            $table->decimal('total', 8, 2);     // الاجمالي
            $table->string('status', 50);       // حاله الفاتوره
            $table->integer('value_status');    // تعبر عن الفاوتير المدفوعه والغير مدفوعه من خلال قيم معينه
            $table->text('note')->nullable();   //
            $table->date('payment_date')->nullable();
            $table->string('user');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
