<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNepalFeeManagementSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Fee Categories
        Schema::create('fee_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->enum('fee_type', [
                'admission',
                'tuition_monthly',
                'annual',
                'exam',
                'transport',
                'hostel',
                'lab',
                'library',
                'other',
            ])->default('other');
            $table->boolean('is_taxable')->default(false);
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Fee Structures
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 150);
            $table->unsignedInteger('fee_category_id');
            $table->string('academic_year', 50);
            $table->unsignedInteger('my_class_id')->nullable();
            $table->unsignedInteger('section_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('period_type', ['one_time', 'monthly', 'term', 'annual'])->default('monthly');
            $table->unsignedSmallInteger('due_day')->nullable()->default(10);
            $table->boolean('is_taxable')->default(false);
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('fee_category_id')->references('id')->on('fee_categories')->onDelete('cascade');
            $table->foreign('my_class_id')->references('id')->on('my_classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['academic_year', 'my_class_id']);
        });

        // 3. Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no', 100)->unique();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('my_class_id');
            $table->unsignedInteger('section_id')->nullable();
            $table->string('academic_year', 50);
            $table->string('fee_period', 100)->nullable();
            $table->date('invoice_date');
            $table->string('invoice_date_bs', 20);
            $table->date('due_date');
            $table->string('due_date_bs', 20);
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('taxable_amount', 12, 2)->default(0.00);
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('net_total', 12, 2)->default(0.00);
            $table->decimal('paid_amount', 12, 2)->default(0.00);
            $table->decimal('balance', 12, 2)->default(0.00);
            $table->enum('status', ['unpaid', 'partially_paid', 'paid', 'cancelled'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->unsignedInteger('created_by');
            $table->string('idempotency_token', 100)->nullable()->unique();
            $table->unsignedInteger('legacy_pr_id')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('my_class_id')->references('id')->on('my_classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['student_id', 'academic_year']);
            $table->index('status');
        });

        // 4. Invoice Line Items
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('fee_category_id')->nullable();
            $table->unsignedInteger('fee_structure_id')->nullable();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->decimal('unit_price', 12, 2);
            $table->decimal('quantity', 8, 2)->default(1.00);
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('taxable_amount', 12, 2)->default(0.00);
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('net_amount', 12, 2);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('fee_category_id')->references('id')->on('fee_categories')->onDelete('set null');
            $table->foreign('fee_structure_id')->references('id')->on('fee_structures')->onDelete('set null');
        });

        // 5. Fee Payments (Receipts)
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('receipt_no', 100)->unique();
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('student_id');
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'cheque', 'esewa', 'khalti', 'other'])->default('cash');
            $table->string('transaction_reference', 150)->nullable();
            $table->date('payment_date');
            $table->string('payment_date_bs', 20);
            $table->string('academic_year', 50);
            $table->unsignedInteger('received_by');
            $table->text('notes')->nullable();
            $table->enum('status', ['completed', 'refunded', 'partially_refunded', 'cancelled'])->default('completed');
            $table->string('idempotency_token', 100)->nullable()->unique();
            $table->unsignedInteger('legacy_pr_id')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['student_id', 'academic_year']);
            $table->index('payment_date');
        });

        // 6. Payment Allocations
        Schema::create('fee_payment_allocations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fee_payment_id');
            $table->unsignedInteger('invoice_id');
            $table->decimal('allocated_amount', 12, 2);
            $table->timestamps();

            $table->foreign('fee_payment_id')->references('id')->on('fee_payments')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });

        // 7. Student Ledger Entries
        Schema::create('student_ledger_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->string('academic_year', 50);
            $table->enum('entry_type', ['opening_balance', 'invoice', 'payment', 'discount_waiver', 'refund', 'adjustment']);
            $table->date('entry_date');
            $table->string('entry_date_bs', 20);
            $table->string('reference_no', 100);
            $table->decimal('debit', 12, 2)->default(0.00);
            $table->decimal('credit', 12, 2)->default(0.00);
            $table->decimal('running_balance', 12, 2)->default(0.00);
            $table->string('source_type', 100)->nullable();
            $table->unsignedInteger('source_id')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('authorized_by');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('authorized_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['student_id', 'academic_year', 'entry_date']);
        });

        // 8. Fee Adjustments, Waivers & Refunds
        Schema::create('fee_adjustments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('adjustment_no', 100)->unique();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('fee_payment_id')->nullable();
            $table->enum('adjustment_type', ['discount', 'waiver', 'scholarship', 'refund', 'correction']);
            $table->decimal('amount', 12, 2);
            $table->text('reason');
            $table->unsignedInteger('authorized_by');
            $table->string('academic_year', 50);
            $table->date('adjustment_date');
            $table->string('adjustment_date_bs', 20);
            $table->string('idempotency_token', 100)->nullable()->unique();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
            $table->foreign('fee_payment_id')->references('id')->on('fee_payments')->onDelete('set null');
            $table->foreign('authorized_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['student_id', 'academic_year']);
        });

        // Seed default standard Nepal school fee categories (Tax-exempt by default under Nepal VAT law)
        $now = now();
        $categories = [
            [
                'name' => 'Monthly Tuition Fee',
                'code' => 'TUITION_MONTHLY',
                'fee_type' => 'tuition_monthly',
                'description' => 'Regular monthly educational instruction fee',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Admission Fee',
                'code' => 'ADMISSION',
                'fee_type' => 'admission',
                'description' => 'One-time student admission and enrollment fee',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Annual Charges',
                'code' => 'ANNUAL',
                'fee_type' => 'annual',
                'description' => 'Annual development and maintenance charges',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Examination Fee',
                'code' => 'EXAM',
                'fee_type' => 'exam',
                'description' => 'Terminal / Annual examination charges',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Transportation Fee',
                'code' => 'TRANSPORT',
                'fee_type' => 'transport',
                'description' => 'School bus / van transportation service fee',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Hostel Fee',
                'code' => 'HOSTEL',
                'fee_type' => 'hostel',
                'description' => 'Boarding and lodging charges for residential students',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Laboratory & Practical Fee',
                'code' => 'LAB',
                'fee_type' => 'lab',
                'description' => 'Science lab, computer lab and practical materials fee',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Library Fee',
                'code' => 'LIBRARY',
                'fee_type' => 'library',
                'description' => 'Library resource access and book circulation fee',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Extra-Curricular Activities (ECA)',
                'code' => 'ECA',
                'fee_type' => 'other',
                'description' => 'Sports, arts, music, and club activity charges',
                'is_taxable' => false,
                'tax_rate' => 0.00,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('fee_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_adjustments');
        Schema::dropIfExists('student_ledger_entries');
        Schema::dropIfExists('fee_payment_allocations');
        Schema::dropIfExists('fee_payments');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('fee_structures');
        Schema::dropIfExists('fee_categories');
    }
}
