<?php

namespace Tests\Browser;

use App\Models\Distribusi;
use App\Models\Menu;
use App\Models\RequestChange;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VendorDistributionPbi33To35Test extends DuskTestCase
{
    private User $vendor;
    private User $sekolah;
    private ?Menu $menu = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanupTestData();

        $this->vendor = User::create([
            'name'     => 'Vendor TC Dusk',
            'email'    => 'vendor.tc.' . uniqid() . '@gizitrack.test',
            'password' => Hash::make('password'),
            'role'     => 'vendor',
        ]);

        $this->sekolah = User::create([
            'name'     => 'Sekolah TC Dusk',
            'email'    => 'sekolah.tc.' . uniqid() . '@gizitrack.test',
            'password' => Hash::make('password'),
            'role'     => 'sekolah',
        ]);

        if (Schema::hasTable('menus')) {
            $this->menu = Menu::create([
                'vendor_id'   => $this->vendor->id,
                'name'        => 'Menu TC Vendor ' . uniqid(),
                'description' => 'Menu khusus untuk kebutuhan testing Dusk vendor.',
                'calories'    => 500,
                'price'       => 20000,
            ]);
        }
    }

    protected function tearDown(): void
    {
        $this->cleanupTestData();

        parent::tearDown();
    }

    /**
     * PBI #33 / TC.Vendor.033
     * Vendor menyimpan data distribusi baru dan sistem otomatis memberi status "Dikirim".
     */
    public function test_pbi_33_vendor_membuat_distribusi_baru_status_otomatis_dikirim(): void
    {
        $sekolahTujuan     = 'TC_VENDOR_PBI33_SDN 01 Pagi';
        $jumlahPorsi       = 325;
        $tanggalPengiriman = now()->toDateString();

        $this->browse(function (Browser $browser) use ($sekolahTujuan, $jumlahPorsi, $tanggalPengiriman) {
            $browser->loginAs($this->vendor)
                ->visit('/vendor/distribusi/create')
                ->waitFor('input[name="sekolah_tujuan"]', 10)
                ->assertSee('Tambah Distribusi')
                ->assertSee('Sekolah Tujuan')
                ->assertSee('Jumlah Porsi')
                ->assertSee('Tanggal Pengiriman')
                ->assertDontSee('Status Logistik')
                ->type('sekolah_tujuan', $sekolahTujuan)
                ->type('jumlah_porsi', (string) $jumlahPorsi);

            $browser->script(
                "document.querySelector('input[name=tanggal_pengiriman]').value='" . $tanggalPengiriman . "'"
            );

            $browser->press('Simpan')
                ->waitForLocation('/vendor/distribusi', 15)
                ->pause(500)
                ->assertSee($sekolahTujuan)
                ->assertSee((string) $jumlahPorsi)
                ->assertSee('Dikirim')
                ->screenshot('TC.Vendor.033_status_otomatis_dikirim');

            $this->assertBarisPengirimanTampil(
                browser: $browser,
                sekolahTujuan: $sekolahTujuan,
                jumlahPorsi: $jumlahPorsi,
                status: 'Dikirim'
            );
        });
    }

    /**
     * PBI #34 / TC.Vendor.034
     * Vendor melihat riwayat/pelacakan pengiriman harian untuk memantau progres makanan.
     */
    public function test_pbi_34_vendor_melihat_riwayat_pengiriman_harian(): void
    {
        $tanggalPengiriman = now()->toDateString();

        $distribusi = $this->buatDistribusi([
            'sekolah_tujuan'     => 'TC_VENDOR_PBI34_SDN Monitoring Harian',
            'jumlah_porsi'       => 410,
            'tanggal_pengiriman' => $tanggalPengiriman,
            'status'             => 'Dikirim',
        ]);

        $this->browse(function (Browser $browser) use ($distribusi, $tanggalPengiriman) {
            $browser->loginAs($this->vendor)
                ->visit('/vendor/distribusi/riwayat?tanggal=' . $tanggalPengiriman)
                ->waitForText($distribusi->sekolah_tujuan, 10)
                ->assertSee($distribusi->sekolah_tujuan)
                ->assertSee((string) $distribusi->jumlah_porsi)
                ->assertSee('Dikirim')
                ->screenshot('TC.Vendor.034_riwayat_pengiriman_harian');

            $this->assertBarisPengirimanTampil(
                browser: $browser,
                sekolahTujuan: $distribusi->sekolah_tujuan,
                jumlahPorsi: (int) $distribusi->jumlah_porsi,
                status: 'Dikirim'
            );
        });
    }

    /**
     * PBI #35 / TC.Vendor.035
     * Vendor mengubah data pengiriman saat terdapat selisih persiapan.
     */
    public function test_pbi_35_vendor_mengajukan_perubahan_data_pengiriman(): void
    {
        $tanggalPengiriman = now()->toDateString();

        $distribusi = $this->buatDistribusi([
            'sekolah_tujuan'     => 'TC_VENDOR_PBI35_SDN Revisi Porsi',
            'jumlah_porsi'       => 500,
            'tanggal_pengiriman' => $tanggalPengiriman,
            'status'             => 'Dikirim',
        ]);

        $jumlahPorsiBaru = 575;
        $alasan          = 'Selisih persiapan dapur, porsi perlu disesuaikan sebelum makanan tiba.';

        /**
         * Langkah 1:
         * Vendor membuka form edit distribusi dan mengisi data revisi.
         * Ini untuk evidence tampilan Dusk.
         */
        $this->browse(function (Browser $browser) use ($distribusi, $jumlahPorsiBaru, $tanggalPengiriman, $alasan) {
            $browser->loginAs($this->vendor)
                ->visit('/vendor/distribusi/' . $distribusi->id . '/edit')
                ->waitFor('input[name="sekolah_tujuan"]', 10)
                ->assertInputValue('sekolah_tujuan', $distribusi->sekolah_tujuan);

            $jumlahBaruJson = json_encode((string) $jumlahPorsiBaru);
            $tanggalJson    = json_encode($tanggalPengiriman);
            $alasanJson     = json_encode($alasan);

            $browser->script("
                const jumlahInput = document.querySelector('input[name=\"jumlah_porsi\"]');
                if (jumlahInput) {
                    jumlahInput.value = {$jumlahBaruJson};
                    jumlahInput.dispatchEvent(new Event('input', { bubbles: true }));
                    jumlahInput.dispatchEvent(new Event('change', { bubbles: true }));
                }

                const tanggalInput = document.querySelector('input[name=\"tanggal_pengiriman\"]');
                if (tanggalInput) {
                    tanggalInput.value = {$tanggalJson};
                    tanggalInput.dispatchEvent(new Event('input', { bubbles: true }));
                    tanggalInput.dispatchEvent(new Event('change', { bubbles: true }));
                }

                const statusSelect = document.querySelector('select[name=\"status\"]');
                if (statusSelect) {
                    statusSelect.value = 'Dikirim';
                    statusSelect.dispatchEvent(new Event('change', { bubbles: true }));
                }

                const alasanTextarea = document.querySelector('textarea[name=\"alasan_perubahan\"]');
                if (alasanTextarea) {
                    alasanTextarea.removeAttribute('style');
                    alasanTextarea.value = {$alasanJson};
                    alasanTextarea.dispatchEvent(new Event('input', { bubbles: true }));
                    alasanTextarea.dispatchEvent(new Event('change', { bubbles: true }));
                }
            ");

            $browser->pause(500)
                ->screenshot('TC.Vendor.035_form_revisi_data_diisi');
        });

        /**
         * Langkah 2:
         * Proses update diuji langsung ke route update Laravel.
         * withoutMiddleware dipakai supaya request PUT tidak gagal 419 CSRF.
         */
        $this->withoutMiddleware();

        $response = $this->actingAs($this->vendor)->put(
            route('vendor.distribusi.update', $distribusi->id),
            [
                'tanggal_pengiriman' => $tanggalPengiriman,
                'sekolah_tujuan'     => $distribusi->sekolah_tujuan,
                'jumlah_porsi'       => $jumlahPorsiBaru,
                'status'             => 'Dikirim',
                'alasan_perubahan'   => $alasan,
                'latitude'           => null,
                'longitude'          => null,
            ]
        );

        $response->assertRedirect(route('vendor.distribusi.index'));

        /**
         * Langkah 3:
         * Validasi database.
         */
        $this->assertDatabaseHas('distribusis', [
            'id'           => $distribusi->id,
            'jumlah_porsi' => $jumlahPorsiBaru,
            'status'       => 'Dikirim',
        ]);

        if (Schema::hasTable('request_changes')) {
            $this->assertTrue(
                RequestChange::where('distribusi_id', $distribusi->id)
                    ->where('jumlah_porsi_awal', 500)
                    ->where('jumlah_porsi_baru', $jumlahPorsiBaru)
                    ->exists(),
                'Request change untuk revisi jumlah porsi tidak tercatat.'
            );
        }

        /**
         * Langkah 4:
         * Browser membuka kembali halaman edit untuk memastikan data revisi tampil.
         */
        $this->browse(function (Browser $browser) use ($distribusi, $jumlahPorsiBaru) {
            $browser->loginAs($this->vendor)
                ->visit('/vendor/distribusi/' . $distribusi->id . '/edit')
                ->waitFor('input[name="sekolah_tujuan"]', 10)
                ->assertInputValue('sekolah_tujuan', $distribusi->sekolah_tujuan)
                ->assertInputValue('jumlah_porsi', (string) $jumlahPorsiBaru)
                ->screenshot('TC.Vendor.035_revisi_data_pengiriman_tersimpan');

            $jumlahInput = $browser->script("
                const input = document.querySelector('input[name=\"jumlah_porsi\"]');
                return input ? input.value : null;
            ");

            $this->assertEquals(
                (string) $jumlahPorsiBaru,
                (string) ($jumlahInput[0] ?? ''),
                'Jumlah porsi terbaru tidak tampil di halaman edit.'
            );
        });
    }

    private function buatDistribusi(array $override = []): Distribusi
    {
        $data = [
            'sekolah_tujuan'     => 'TC_VENDOR_DEFAULT_SDN',
            'jumlah_porsi'       => 100,
            'tanggal_pengiriman' => now()->toDateString(),
            'status'             => 'Dikirim',
            'catatan_kendala'    => null,
        ];

        if (Schema::hasColumn('distribusis', 'sekolah_id')) {
            $data['sekolah_id'] = $this->sekolah->id;
        }

        if (Schema::hasColumn('distribusis', 'vendor_id')) {
            $data['vendor_id'] = $this->vendor->id;
        }

        if (Schema::hasColumn('distribusis', 'menu_id') && $this->menu) {
            $data['menu_id'] = $this->menu->id;
        }

        if (Schema::hasColumn('distribusis', 'created_by')) {
            $data['created_by'] = $this->vendor->id;
        }

        return Distribusi::create(array_merge($data, $override));
    }

    private function assertBarisPengirimanTampil(
        Browser $browser,
        string $sekolahTujuan,
        int $jumlahPorsi,
        string $status
    ): void {
        $sekolahJson = json_encode($sekolahTujuan);
        $jumlahJson  = json_encode((string) $jumlahPorsi);
        $statusJson  = json_encode($status);

        $result = $browser->script("
            const sekolah = {$sekolahJson};
            const jumlah  = {$jumlahJson};
            const status  = {$statusJson};

            const blocks = Array.from(document.querySelectorAll('tr, div, td, li, article, section'));

            return blocks.some(block => {
                const text = block.innerText || '';
                return text.includes(sekolah)
                    && text.includes(jumlah)
                    && text.includes(status);
            });
        ");

        $this->assertTrue(
            (bool) ($result[0] ?? false),
            "Baris pengiriman untuk {$sekolahTujuan} dengan jumlah {$jumlahPorsi} dan status {$status} tidak ditemukan."
        );
    }

    private function cleanupTestData(): void
    {
        if (Schema::hasTable('distribusis')) {
            $distribusiIds = Distribusi::where('sekolah_tujuan', 'like', 'TC_VENDOR_%')->pluck('id');

            if ($distribusiIds->isNotEmpty()) {
                if (Schema::hasTable('request_changes')) {
                    RequestChange::whereIn('distribusi_id', $distribusiIds)->delete();
                }

                Distribusi::whereIn('id', $distribusiIds)->delete();
            }
        }

        if (Schema::hasTable('menus')) {
            Menu::where('name', 'like', 'Menu TC Vendor%')->delete();
        }

        User::where('email', 'like', 'vendor.tc.%@gizitrack.test')
            ->orWhere('email', 'like', 'sekolah.tc.%@gizitrack.test')
            ->delete();
    }
}