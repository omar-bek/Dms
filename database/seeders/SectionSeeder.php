<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboards 1 - 2
        Section::updateOrCreate(['id' => 1], ['name' => 'admin_general_dashboard', 'caption' => 'General_Dashboard']);
        Section::updateOrCreate(['id' => 2], ['name' => 'admin_general_dashboard_show', 'section_group_id' => 1, 'caption' => "General_Dashboard_page"]);

        // Roles 3 - 7
        Section::updateOrCreate(['id' => 3], ['name' => 'Admin_Roles', 'caption' => 'Admin_Roles']);
        Section::updateOrCreate(['id' => 4], ['name' => 'Show_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Show_Admin_Roles']);
        Section::updateOrCreate(['id' => 5], ['name' => 'Create_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Create_Admin_Roles']);
        Section::updateOrCreate(['id' => 6], ['name' => 'Edit_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Edit_Admin_Roles']);
        Section::updateOrCreate(['id' => 7], ['name' => 'Update_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Update_Admin_Roles']);
        Section::updateOrCreate(['id' => 8], ['name' => 'Delete_Admin_Roles', 'section_group_id' => 3, 'caption' => 'Delete_Admin_Roles']);

        // Users Management 9 - 13
        Section::updateOrCreate(['id' => 9], ['name' => 'user_management', 'caption' => 'user_management']);
        Section::updateOrCreate(['id' => 10], ['name' => 'all_users', 'section_group_id' => 9, 'caption' => 'show_all_users']);
        Section::updateOrCreate(['id' => 11], ['name' => 'change_users_role', 'section_group_id' => 9, 'caption' => 'change_users_role']);
        Section::updateOrCreate(['id' => 12], ['name' => 'change_users_status', 'section_group_id' => 9, 'caption' => 'change_users_status']);
        Section::updateOrCreate(['id' => 13], ['name' => 'delete_user', 'section_group_id' => 9, 'caption' => 'delete_user']);

        // Departments 14 - 19
        Section::updateOrCreate(['id' => 14], ['name' => 'departments', 'caption' => 'departments']);
        Section::updateOrCreate(['id' => 15], ['name' => 'all_departments',  'section_group_id' => 14, 'caption' => 'all_departments']);
        Section::updateOrCreate(['id' => 16], ['name' => 'create_department',  'section_group_id' => 14, 'caption' => 'create_department']);
        Section::updateOrCreate(['id' => 17], ['name' => 'edit_department',  'section_group_id' => 14, 'caption' => 'edit_department']);
        Section::updateOrCreate(['id' => 18], ['name' => 'delete_department',  'section_group_id' => 14, 'caption' => 'delete_department']);
        Section::updateOrCreate(['id' => 19], ['name' => 'show_department',  'section_group_id' => 14, 'caption' => 'show_department']);

        // Documents 20 - 28
        Section::updateOrCreate(['id' => 20], ['name' => 'documents', 'caption' => 'documents']);
        Section::updateOrCreate(['id' => 21], ['name' => 'all_documents',  'section_group_id' => 20, 'caption' => 'all_documents']);
        Section::updateOrCreate(['id' => 22], ['name' => 'create_documents',  'section_group_id' => 20, 'caption' => 'create_documents']);
        Section::updateOrCreate(['id' => 23], ['name' => 'edit_documents',  'section_group_id' => 20, 'caption' => 'edit_documents']);
        Section::updateOrCreate(['id' => 24], ['name' => 'delete_documents',  'section_group_id' => 20, 'caption' => 'delete_documents']);
        Section::updateOrCreate(['id' => 25], ['name' => 'show_documents',  'section_group_id' => 20, 'caption' => 'show_documents']);
        Section::updateOrCreate(['id' => 26], ['name' => 'share_with_departments',  'section_group_id' => 20, 'caption' => 'share_with_departments']);
        Section::updateOrCreate(['id' => 27], ['name' => 'follow_document',  'section_group_id' => 20, 'caption' => 'follow_document']);
        Section::updateOrCreate(['id' => 28], ['name' => 'show_departments_documents',  'section_group_id' => 20, 'caption' => 'show_departments_documents']);
        Section::updateOrCreate(['id' => 29], ['name' => 'add_sginature',  'section_group_id' => 20, 'caption' => 'add_sginature']);


        // Archive 30 - //
        Section::updateOrCreate(['id' => 30], ['name' => 'archive', 'caption' => 'archive']);
        Section::updateOrCreate(['id' => 31], ['name' => 'show_archive',  'section_group_id' => 30, 'caption' => 'show_archive']);
        Section::updateOrCreate(['id' => 32], ['name' => 'moved_to_archive',  'section_group_id' => 30, 'caption' => 'moved_to_archive']);
        Section::updateOrCreate(['id' => 33], ['name' => 'delete_from_archive',  'section_group_id' => 30, 'caption' => 'delete_from_archive']);

        // Upload Pdf File
        Section::updateOrCreate(['id' => 34], ['name' => 'uploadpdf', 'caption' => 'uploadpdf']);
        Section::updateOrCreate(['id' => 35], ['name' => 'save_pdf',  'section_group_id' => 34, 'caption' => 'uploadpdf']);

    }
}
