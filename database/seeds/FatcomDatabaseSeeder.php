<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class FatcomDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('CategoriasTableSeeder');
        $this->seed('ClientesTableSeeder');
        $this->seed('ColoresTableSeeder');
        $this->seed('DepositosTableSeeder');
        $this->seed('GenerosTableSeeder');
        $this->seed('LocalidadesTableSeeder');
        $this->seed('MarcasTableSeeder');
        $this->seed('MonedasTableSeeder');
        $this->seed('SubcategoriasTableSeeder');
        $this->seed('SucursalesTableSeeder');
        $this->seed('TallasTableSeeder');
        $this->seed('TamaniosTableSeeder');
        $this->seed('UnidadesTableSeeder');
        $this->seed('UsosTableSeeder');
        $this->seed('VentasDetalleTipoEstadosTableSeeder');
        $this->seed('VentasEstadosTableSeeder');
        $this->seed('VentasTiposTableSeeder');
        $this->seed('TamaniosTableSeeder');

        $this->seed('FatcomDataTypesTableSeeder');
        $this->seed('FatcomDataRowsTableSeeder');
        $this->seed('MenusTableSeeder');
        $this->seed('FatcomMenuItemsTableSeeder');
        $this->seed('FatcomRolesTableSeeder');
        $this->seed('FatcomPermissionsTableSeeder');
        $this->seed('FatcomPermissionRoleTableSeeder');
        $this->seed('FatcomSettingsTableSeeder');
        $this->seed('UsersTableSeeder');

        $this->seed('TemplatesTableSeeder');
        $this->seed('PagesTableSeeder');
        $this->seed('SectionsTableSeeder');
        $this->seed('BlocksTableSeeder');
        $this->seed('BlockInputTableSeeder');

        $this->seed('PasarelaPagosTableSeeder');
    }
}
