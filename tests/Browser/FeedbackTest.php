<?php

namespace Tests\Browser;

use App\Models\Distribusi;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FeedbackTest extends DuskTestCase
{
    use DatabaseMigrations, MakesHttpRequests;

    /**
     * TC.PBI19.001 — Sekolah buka halaman form feedback
     */
    public function test_pbi19_001(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.feedbacks.create"))
                ->pause(1500)
                ->assertSee("Tulis Feedback")
                ->assertPresent("select[name=distribution_id]")
                ->assertPresent("textarea[name=catatan]");
        });
    }

    /**
     * TC.PBI19.002 — Sekolah kirim feedback valid
     */
    public function test_pbi19_002(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah, $dist) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.feedbacks.create"))
                ->pause(1500)
                ->select("distribution_id", (string) $dist->id)
                ->pause(500)
                ->type("catatan", "Porsi kurang 10, kualitas baik.")
                ->pause(500)
                ->press("Simpan")
                ->pause(2000)
                ->assertSee("Feedback berhasil dikirimkan!");
        });

        $this->assertDatabaseHas("feedbacks", [
            "distribution_id" => $dist->id,
            "user_id" => $sekolah->id,
            "catatan" => "Porsi kurang 10, kualitas baik.",
        ]);
    }

    /**
     * TC.PBI19.003 — Sekolah kirim feedback tanpa catatan (negatif)
     */
    public function test_pbi19_003(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah, $dist) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.feedbacks.create"))
                ->pause(1500)
                ->select("distribution_id", (string) $dist->id)
                ->pause(500)
                // Skip typing catatan
                ->press("Simpan")
                ->pause(1500)
                // Redirects back to form because of validation error
                ->assertPathIs("/sekolah/feedbacks/create");
        });
    }

    /**
     * TC.PBI20.001 — Sekolah lihat status distribusi miliknya
     */
    public function test_pbi20_001(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.distributions.index"))
                ->pause(1500)
                ->assertSee("Terkirim");
        });
    }

    /**
     * TC.PBI20.002 — Sekolah tidak lihat distribusi sekolah lain (negatif)
     */
    public function test_pbi20_002(): void
    {
        $sekolah1 = User::factory()->create([
            "name" => "SDN 01 Pagi",
            "role" => "sekolah",
        ]);
        $sekolah2 = User::factory()->create([
            "name" => "SMPN 15 Jakarta",
            "role" => "sekolah",
        ]);

        Distribusi::create([
            "sekolah_tujuan" => "SMPN 15 Jakarta",
            "jumlah_porsi" => 200,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah1) {
            $browser
                ->loginAs($sekolah1)
                ->visit(route("sekolah.distributions.index"))
                ->pause(1500)
                ->assertDontSee("SMPN 15 Jakarta");
        });
    }

    /**
     * TC.PBI20.003 — Admin lihat semua distribusi
     */
    public function test_pbi20_003(): void
    {
        $admin = User::factory()->create(["role" => "admin"]);
        Distribusi::create([
            "sekolah_tujuan" => "SDN 01 Pagi",
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);
        Distribusi::create([
            "sekolah_tujuan" => "SMPN 15 Jakarta",
            "jumlah_porsi" => 200,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Pending",
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit(route("admin.distributions.index"))
                ->pause(1500)
                ->assertSee("SDN 01 Pagi")
                ->assertSee("SMPN 15 Jakarta");
        });
    }

    /**
     * TC.PBI21.001 — Sekolah konfirmasi penerimaan
     */
    public function test_pbi21_001(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.distributions.index"))
                ->pause(1500)
                ->press("Konfirmasi")
                ->pause(1000)
                ->press("Ya, Konfirmasi")
                ->pause(2000)
                ->assertSee("Distribusi berhasil dikonfirmasi diterima.")
                ->assertSee("Diterima");
        });
    }

    /**
     * TC.PBI21.002 — Sekolah terima dengan catatan
     */
    public function test_pbi21_002(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah, $dist) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.distributions.index"))
                ->pause(1500)
                ->press("Catatan")
                ->pause(1000)
                ->type("catatan", "Porsi kurang 5.")
                ->pause(500)
                ->press("Simpan")
                ->pause(2000)
                ->assertSee("Distribusi berhasil dikonfirmasi dengan catatan.");
        });

        $this->assertDatabaseHas("distribusis", [
            "id" => $dist->id,
            "status" => "Diterima Sebagian",
        ]);
    }

    /**
     * TC.PBI21.003 — Sekolah tidak bisa konfirmasi distribusi sekolah lain (HTTP test)
     */
    public function test_pbi21_003(): void
    {
        $sekolah1 = User::factory()->create(["role" => "sekolah"]);
        $sekolah2 = User::factory()->create(["role" => "sekolah"]);
        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah2->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Terkirim",
        ]);

        $this->actingAs($sekolah1)
            ->withoutMiddleware(
                \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            )
            ->patch(route("sekolah.distributions.update", $dist->id), [
                "action" => "terima",
            ])
            ->assertStatus(403);
    }

    /**
     * TC.PBI22.001 — Sekolah hapus feedback miliknya
     */
    public function test_pbi22_001(): void
    {
        $sekolah = User::factory()->create(["role" => "sekolah"]);
        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Diterima",
        ]);

        $feedback = Feedback::create([
            "distribution_id" => $dist->id,
            "user_id" => $sekolah->id,
            "catatan" => "Hapus ini.",
        ]);

        $this->browse(function (Browser $browser) use ($sekolah) {
            $browser
                ->loginAs($sekolah)
                ->visit(route("sekolah.feedbacks.index"))
                ->pause(1500)
                ->assertSee("Hapus ini.")
                ->press("Hapus")
                ->pause(500)
                ->acceptDialog()
                ->pause(2000)
                ->assertDontSee("Hapus ini.");
        });
    }

    /**
     * TC.PBI22.002 — Sekolah tidak bisa hapus feedback sekolah lain (HTTP test)
     */
    public function test_pbi22_002(): void
    {
        $sekolah1 = User::factory()->create(["role" => "sekolah"]);
        $sekolah2 = User::factory()->create(["role" => "sekolah"]);

        $dist = Distribusi::create([
            "sekolah_tujuan" => $sekolah2->name,
            "jumlah_porsi" => 100,
            "tanggal_pengiriman" => now()->toDateString(),
            "status" => "Diterima",
        ]);

        $feedback = Feedback::create([
            "distribution_id" => $dist->id,
            "user_id" => $sekolah2->id,
            "catatan" => "milik sekolah2",
        ]);

        $this->actingAs($sekolah1)
            ->withoutMiddleware(
                \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            )
            ->delete(route("sekolah.feedbacks.destroy", $feedback->id))
            ->assertStatus(403);

        $this->assertDatabaseHas("feedbacks", ["id" => $feedback->id]);
    }
}
