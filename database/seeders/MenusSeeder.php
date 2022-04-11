<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check1 = Menu::where('name', 'User Access')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 2,
                'name' => 'User Access',
                'url' => 'access_menu',
                'icon' => 'fas fa-users',
            ]);
        }
        $check1 = Menu::where('name', 'Master Client')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 2,
                'name' => 'Master Client',
                'url' => 'client',
                'icon' => 'far fa-handshake',
            ]);
        }
        $check1 = Menu::where('name', 'Contract / PO')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Contract / PO',
                'url' => 'contract-po',
                'icon' => 'fas fa-tasks',
            ]);
        }
        $check1 = Menu::where('name', 'Operational & Cost')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Operational & Cost',
                'url' => 'operational-cost',
                'icon' => 'fas fa-briefcase',
            ]);
        }
        $check1 = Menu::where('name', 'Project Card')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 3,
                'name' => 'Project Card',
                'url' => 'projectcard',
                'icon' => 'fas fa-id-card',
            ]);
        }
        $check1 = Menu::where('name', 'Account Receiveable')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Account Receiveable',
                'url' => 'payments',
                'icon' => 'fas fa-credit-card',
            ]);
        }
        $check1 = Menu::where('name', 'Tax Proof')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Tax Proof',
                'url' => 'taxproof',
                'icon' => 'fas fa-landmark',
            ]);
        }
        $check1 = Menu::where('name', 'Projects Status')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Projects Status',
                'url' => 'projects_status',
                'icon' => 'fas fa-book',
            ]);
        }
        $check1 = Menu::where('name', 'Supplier')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Supplier',
                'url' => 'suplier',
                'icon' => 'fas fa-truck',
            ]);
        }
        $check1 = Menu::where('name', 'Master Status')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 2,
                'name' => 'Master Status',
                'url' => 'progress_status',
                'icon' => 'fas fa-cog',
            ]);
        }
        $check1 = Menu::where('name', 'Type Contract')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 2,
                'name' => 'Type Contract',
                'url' => 'types',
                'icon' => 'fas fa-cog',
            ]);
        }
        $check1 = Menu::where('name', 'Email Configuration')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 2,
                'name' => 'Email Configuration',
                'url' => 'email_configuration',
                'icon' => 'fas fa-envelope',
            ]);
        }
        $check1 = Menu::where('name', 'Account Payable')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Account Payable',
                'url' => 'payable',
                'icon' => 'fas fa-comment-dollar',
            ]);
        }
        $check1 = Menu::where('name', 'Create Contract')->first();
        if ($check1 === null) {
            Menu::create([
                'menu_header_id' => 1,
                'name' => 'Create Contract',
                'url' => 'create.contract',
                'icon' => '',
            ]);
        }
    }
}
