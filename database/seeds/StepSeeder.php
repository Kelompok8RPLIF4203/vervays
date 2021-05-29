<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pembayaran melalui ATM BNI
        DB::table('steps')->insert([
            "id" => 1,
            "paymentMethodId" => 1,
            "order" => 1,
            "step" => "Masukkan Kartu Anda",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 2,
            "paymentMethodId" => 1,
            "order" => 2,
            "step" => "Pilih Bahasa",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 3,
            "paymentMethodId" => 1,
            "order" => 3,
            "step" => "Masukkan PIN ATM Anda",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 4,
            "paymentMethodId" => 1,
            "order" => 4,
            "step" => "Pilih \"Menu Lainnya\"",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 5,
            "paymentMethodId" => 1,
            "order" => 5,
            "step" => "Pilih \"Menu Transfer\"",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 6,
            "paymentMethodId" => 1,
            "order" => 6,
            "step" => "Pilih Jenis rekening yang akan Anda gunakan (Contoh; \"Dari Rekening Tabungan\")",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 7,
            "paymentMethodId" => 1,
            "order" => 7,
            "step" => "Pilih \"Virtual Account Billing\"",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 8,
            "paymentMethodId" => 1,
            "order" => 8,
            "step" => "Masukkan nomor Virtual Account Anda (contoh: 5671)",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 9,
            "paymentMethodId" => 1,
            "order" => 9,
            "step" => "Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 10,
            "paymentMethodId" => 1,
            "order" => 10,
            "step" => "Konfirmasi, apabila telah sesuai, lanjutkan transaksi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 11,
            "paymentMethodId" => 1,
            "order" => 11,
            "step" => "Transaksi Anda telah selesai",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // Pembayaran melalui Mobile Banking BNI
        DB::table('steps')->insert([
            "id" => 12,
            "paymentMethodId" => 2,
            "order" => 1,
            "step" => "Akses BNI Mobile Banking dari handphone kemudian masukkan user ID dan password",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 13,
            "paymentMethodId" => 2,
            "order" => 2,
            "step" => "Pilih menu \"Transfer\"",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 14,
            "paymentMethodId" => 2,
            "order" => 3,
            "step" => "Pilih menu \"Virtual Account Billing\" kemudian pilih rekening debet",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 15,
            "paymentMethodId" => 2,
            "order" => 4,
            "step" => "Masukkan nomor Virtual Account Anda (contoh: 5671) pada menu \"inputbaru\"",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 16,
            "paymentMethodId" => 2,
            "order" => 5,
            "step" => "Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 17,
            "paymentMethodId" => 2,
            "order" => 6,
            "step" => "Konfirmasi transaksi dan masukkan Password Transaksi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 18,
            "paymentMethodId" => 2,
            "order" => 7,
            "step" => "Pembayaran Anda Telah Berhasil",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // Pembayaran melalui Cabang atau Teller BNI
        DB::table('steps')->insert([
            "id" => 19,
            "paymentMethodId" => 3,
            "order" => 1,
            "step" => "Kunjungi Kantor Cabang/outlet BNI terdekat.",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 20,
            "paymentMethodId" => 3,
            "order" => 2,
            "step" => "Informasikan kepada Teller, bahwa ingin melakukan pembayaran “Virtual Account Billing”",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 21,
            "paymentMethodId" => 3,
            "order" => 3,
            "step" => "Serahkan nomor Virtual Account Anda kepada Telle",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 22,
            "paymentMethodId" => 3,
            "order" => 4,
            "step" => "Teller melakukan konfirmasi kepada Anda.",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 23,
            "paymentMethodId" => 3,
            "order" => 5,
            "step" => "Teller memproses Transaksi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 24,
            "paymentMethodId" => 3,
            "order" => 6,
            "step" => "Apabila transaksi Sukses anda akan menerima bukti pembayaran dari Teller tersebut",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // Pembayaran melalui ATM Bank lain
        DB::table('steps')->insert([
            "id" => 25,
            "paymentMethodId" => 4,
            "order" => 1,
            "step" => "Pilih menu \"Transfer antar bank\" atau \"Transfer online antarbank\"",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 26,
            "paymentMethodId" => 4,
            "order" => 2,
            "step" => "Masukkan kode bank BNI (009) atau pilih bank yang dituju yaitu BNI",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 27,
            "paymentMethodId" => 4,
            "order" => 3,
            "step" => "Masukan Nomor Virtual Account pada kolom rekening tujuan, (contoh:5671)",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 28,
            "paymentMethodId" => 4,
            "order" => 4,
            "step" => "Masukkan nominal transfer sesuai tagihan atau kewajiban Anda. Nominal yang berbeda tidak dapat diproses",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 29,
            "paymentMethodId" => 4,
            "order" => 5,
            "step" => "Konfirmasi rincian Anda akan tampil di layar, cek dan apabila sudah sesuai silakan lanjutkan transaksi sampai dengan selesai",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 30,
            "paymentMethodId" => 4,
            "order" => 6,
            "step" => "Transaksi berhasil",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // Pembayaran melalui Indomaret
        DB::table('steps')->insert([
            "id" => 31,
            "paymentMethodId" => 5,
            "order" => 1,
            "step" => "Datang ke gerai Indomaret terdekat",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 32,
            "paymentMethodId" => 5,
            "order" => 2,
            "step" => "Beritahu kasir bahwa Anda akan melakukan pembayaran Vervays",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 33,
            "paymentMethodId" => 5,
            "order" => 3,
            "step" => "Berikan kode pembayaran kepada kasir",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 34,
            "paymentMethodId" => 5,
            "order" => 4,
            "step" => "Serahkan uang pembayaran kepada kasir",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 35,
            "paymentMethodId" => 5,
            "order" => 5,
            "step" => "Kasir memproses transaksi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 36,
            "paymentMethodId" => 5,
            "order" => 6,
            "step" => "Transaksi selesai",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // Pembayaran melalui Alfamart
        DB::table('steps')->insert([
            "id" => 37,
            "paymentMethodId" => 5,
            "order" => 1,
            "step" => "Datang ke gerai Alfamart terdekat",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 38,
            "paymentMethodId" => 5,
            "order" => 2,
            "step" => "Beritahu kasir bahwa Anda akan melakukan pembayaran Vervays",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 39,
            "paymentMethodId" => 5,
            "order" => 3,
            "step" => "Berikan kode pembayaran kepada kasir",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 40,
            "paymentMethodId" => 5,
            "order" => 4,
            "step" => "Serahkan uang pembayaran kepada kasir",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 41,
            "paymentMethodId" => 5,
            "order" => 5,
            "step" => "Kasir memproses transaksi",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('steps')->insert([
            "id" => 42,
            "paymentMethodId" => 5,
            "order" => 6,
            "step" => "Transaksi selesai",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
