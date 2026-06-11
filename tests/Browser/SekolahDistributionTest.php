<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Distribusi;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SekolahDistributionTest extends DuskTestCase
{
    // We handle migrations and seeding manually to ensure sync between browser and server on Windows/SQLite
    protected static $migrationRun = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$migrationRun) {
            $this->artisan("migrate:fresh");
            $this->seed(DatabaseSeeder::class);
            static::$migrationRun = true;
        }
    }

    /**
     * PBI 36: Sekolah can only see 'Dikirim' status by default.
     * [GIZITRACK-36]
     */
    public function test_sekolah_can_only_see_dikirim_status(): void
    {
        $sekolah = User::where("email", "sekolah@gizitrack.test")->first();
        $this->browse(function (Browser $browser) use ($sekolah) {
            $browser
                ->loginAs($sekolah)
                ->visit("/sekolah/distributions")
                ->assertPathIs("/sekolah/distributions")
                ->assertSee("Dikirim")
                ->assertDontSee("Diterima")
                ->screenshot("PBI36_SekolahOnlySeeDikirim");
        });
    }

    /**
     * PBI 37: Sekolah can accept delivery instantly.
     * [GIZITRACK-37]
     */
    public function test_sekolah_can_accept_delivery_instantly(): void
    {
        $sekolah = User::where("email", "sekolah@gizitrack.test")->first();
        $distribution = Distribusi::where("sekolah_id", $sekolah->id)
            ->where("status", "Dikirim")
            ->first();

        $this->browse(function (Browser $browser) use (
            $sekolah,
            $distribution,
        ) {
            $browser
                ->loginAs($sekolah)
                ->visit("/sekolah/distributions")
                ->waitFor("@terima-sesuai-{$distribution->id}")
                ->press("@terima-sesuai-{$distribution->id}")
                ->assertSee("Distribusi berhasil dikonfirmasi diterima.")
                ->screenshot("PBI37_SekolahAcceptDelivery");
        });
    }

    /**
     * PBI 38: Sekolah can submit complaint via modal.
     * [GIZITRACK-38]
     */
    public function test_sekolah_can_submit_complaint_via_modal(): void
    {
        $sekolah = User::where("email", "sekolah@gizitrack.test")->first();
        $distribution = Distribusi::where("sekolah_id", $sekolah->id)
            ->where("status", "Dikirim")
            ->first();

        $this->browse(function (Browser $browser) use (
            $sekolah,
            $distribution,
        ) {
            $browser
                ->loginAs($sekolah)
                ->visit("/sekolah/distributions")
                ->waitFor("@btn-komplain-{$distribution->id}")
                ->pause(1000)
                ->press("@btn-komplain-{$distribution->id}")
                ->pause(1000)
                ->whenAvailable(
                    "#complaint-modal-{$distribution->id}",
                    function ($modal) use ($distribution) {
                        $modal
                            ->type(
                                "textarea[dusk='catatan-{$distribution->id}']",
                                "Porsi kurang 5, rasa hambar.",
                            )
                            ->pause(500)
                            ->press(
                                "button[dusk='submit-komplain-{$distribution->id}']",
                            );
                    },
                )
                ->pause(1000)
                ->assertSee(
                    "Komplain berhasil dikirim dan sedang dalam penanganan.",
                )
                ->screenshot("PBI38_SekolahSubmitComplaint");
        });
    }

    /**
     * PBI 38: Sekolah can resolve complaint.
     * [GIZITRACK-38]
     */
    public function test_sekolah_can_resolve_complaint(): void
    {
        $sekolah = User::where("email", "sekolah@gizitrack.test")->first();

        // Ensure there is a distribution with 'Komplain' status
        $distribution = Distribusi::where("sekolah_id", $sekolah->id)->first();
        $distribution->update(["status" => "Komplain"]);

        $this->browse(function (Browser $browser) use (
            $sekolah,
            $distribution,
        ) {
            $browser
                ->loginAs($sekolah)
                ->visit("/sekolah/distributions?tab=history")
                ->waitFor("@resolve-komplain-{$distribution->id}")
                ->press("@resolve-komplain-{$distribution->id}")
                ->assertSee("Komplain berhasil ditandai selesai.")
                ->screenshot("PBI38_SekolahResolveComplaint");
        });
    }
}
