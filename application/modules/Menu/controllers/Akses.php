<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Akses extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_akses');
        
        // Load language file
        $this->lang->load('rest_controller', 'english');
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        if ($this->input->method() === 'options') {
            exit();
        }
    }

    // ==================== MAIN MENU ACCESS API ====================

    /**
     * GET: Retrieve main menu access
     * URL: /menu/akses/mainmenu
     * URL: /menu/akses/mainmenu?f_deptid=1
     */
    public function mainmenu_get()
    {
        $f_deptid = $this->get('f_deptid');
        
        $data = $this->M_akses->get_akses_mainmenu($f_deptid);
        
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Data akses main menu berhasil diambil',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => []
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * GET: Retrieve specific main menu access by ID
     * URL: /menu/akses/mainmenu/id/1
     */
    public function mainmenu_id_get($id = null)
    {
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->M_akses->get_akses_mainmenu_by_id($id);
        
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Data akses main menu berhasil diambil',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * POST: Create new main menu access
     * URL: /menu/akses/mainmenu
     * Body: {
     *   "id_menu": 1,
     *   "f_deptid": 1,
     *   "r": 1,
     *   "c": 1,
     *   "u": 1,
     *   "d": 1
     * }
     */
    public function mainmenu_post()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['menu_access']) || empty($input['f_deptid'])) {
            $this->response([
                'status' => false,
                'message' => 'menu_access dan f_deptid harus diisi'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $f_deptid = $input['f_deptid'];
        $menu_access = isset($input['menu_access']) ? $input['menu_access'] : [];
        
        // Prepare bulk data
        $bulk_data = [];
        foreach ($menu_access as $item) {
            $bulk_data[] = [
                'id_menu' => $item['id_menu'],
                'f_deptid' => $f_deptid,
                'r' => isset($item['r']) ? $item['r'] : 0,
                'c' => isset($item['c']) ? $item['c'] : 0,
                'u' => isset($item['u']) ? $item['u'] : 0,
                'd' => isset($item['d']) ? $item['d'] : 0,
                'entry_date' => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->M_akses->bulk_update_mainmenu($f_deptid, $bulk_data);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses main menu berhasil ditambahkan',
                'data' => ['total_updated' => count($bulk_data)]
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan akses main menu'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * PUT: Update main menu access
     * URL: /menu/akses/mainmenu/id/1
     * Body: {
     *   "r": 1,
     *   "c": 0,
     *   "u": 1,
     *   "d": 0
     * }
     */
    public function mainmenu_id_put($id = null)
    {
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        // Check if exists
        $exists = $this->M_akses->get_akses_mainmenu_by_id($id);
        if (!$exists) {
            $this->response([
                'status' => false,
                'message' => 'Data akses main menu tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        $data = [
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (isset($input['r'])) $data['r'] = $input['r'];
        if (isset($input['c'])) $data['c'] = $input['c'];
        if (isset($input['u'])) $data['u'] = $input['u'];
        if (isset($input['d'])) $data['d'] = $input['d'];

        $result = $this->M_akses->update_akses_mainmenu($id, $data);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses main menu berhasil diupdate',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal mengupdate akses main menu'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * DELETE: Delete main menu access
     * URL: /menu/akses/mainmenu/id/1
     */
    public function mainmenu_id_delete($id = null)
    {
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Check if exists
        $exists = $this->M_akses->get_akses_mainmenu_by_id($id);
        if (!$exists) {
            $this->response([
                'status' => false,
                'message' => 'Data akses main menu tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        // Delete related submenu access
        $this->M_akses->delete_submenu_by_mainmenu($exists->id_menu, $exists->f_deptid);

        $result = $this->M_akses->delete_akses_mainmenu($id);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses main menu dan submenu terkait berhasil dihapus'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menghapus akses main menu'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * POST: Bulk update main menu access for department
     * URL: /menu/akses/mainmenu/bulk
     * Body: {
     *   "f_deptid": 1,
     *   "menu_access": [
     *     {"id_menu": 1, "r": 1, "c": 1, "u": 1, "d": 1},
     *     {"id_menu": 2, "r": 1, "c": 0, "u": 0, "d": 0}
     *   ]
     * }
     */
    public function mainmenu_bulk_post()
    {
        $input = json_decode(file_get_contents('php://input'), true);
     
        if (empty($input['f_deptid'])) {
            $this->response([
                'status' => false,
                'message' => 'f_deptid harus diisi'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $f_deptid = $input['f_deptid'];
        $menu_access = isset($input['menu_access']) ? $input['menu_access'] : [];
        
        // Prepare bulk data
        $bulk_data = [];
        foreach ($menu_access as $item) {
            $bulk_data[] = [
                'id_menu' => $item['id_menu'],
                'f_deptid' => $f_deptid,
                'r' => isset($item['r']) ? $item['r'] : 0,
                'c' => isset($item['c']) ? $item['c'] : 0,
                'u' => isset($item['u']) ? $item['u'] : 0,
                'd' => isset($item['d']) ? $item['d'] : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->M_akses->bulk_update_mainmenu($f_deptid, $bulk_data);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses main menu berhasil diupdate secara bulk',
                'data' => ['total_updated' => count($bulk_data)]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal mengupdate akses main menu secara bulk'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ==================== SUB MENU ACCESS API ====================

    /**
     * GET: Retrieve sub menu access
     * URL: /menu/akses/submenu
     * URL: /menu/akses/submenu?f_deptid=1
     * URL: /menu/akses/submenu?f_deptid=1&id_menu=1
     */
    public function submenu_get()
    {
        $f_deptid = $this->get('f_deptid');
        $id_menu = $this->get('id_menu');
        
        $data = $this->M_akses->get_akses_submenu($f_deptid, $id_menu);
        
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Data akses sub menu berhasil diambil',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => []
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * GET: Retrieve specific sub menu access by ID
     * URL: /menu/akses/submenu/id/1
     */
    public function submenu_id_get($id = null)
    {
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = $this->M_akses->get_akses_submenu_by_id($id);
        
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Data akses sub menu berhasil diambil',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * POST: Create new sub menu access
     * URL: /menu/akses/submenu
     * Body: {
     *   "id_sub_menu": 1,
     *   "f_deptid": 1,
     *   "r": 1,
     *   "c": 1,
     *   "u": 1,
     *   "d": 1
     * }
     */
    public function submenu_post()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['submenu_access']) || empty($input['f_deptid'])) {
            $this->response([
                'status' => false,
                'message' => 'submenu_access dan f_deptid harus diisi'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // // Check if already exists
        // $exists = $this->M_akses->check_akses_submenu_exists($input['id_sub_menu'], $input['f_deptid']);
        // if ($exists) {
        //     $this->response([
        //         'status' => false,
        //         'message' => 'Akses sub menu untuk department ini sudah ada'
        //     ], REST_Controller::HTTP_CONFLICT);
        //     return;
        // }

        // $data = [
        //     'id_sub_menu' => $input['id_sub_menu'],
        //     'f_deptid' => $input['f_deptid'],
        //     'r' => isset($input['r']) ? $input['r'] : 0,
        //     'c' => isset($input['c']) ? $input['c'] : 0,
        //     'u' => isset($input['u']) ? $input['u'] : 0,
        //     'd' => isset($input['d']) ? $input['d'] : 0,
        //     'created_at' => date('Y-m-d H:i:s')
        // ];

        // $result = $this->M_akses->create_akses_submenu($data);
        $f_deptid = $input['f_deptid'];
        $submenu_access = isset($input['submenu_access']) ? $input['submenu_access'] : [];
        
        // Prepare bulk data
        $bulk_data = [];
        foreach ($submenu_access as $item) {
            $bulk_data[] = [
                'id_sub_menu' => $item['id_sub_menu'],
                'f_deptid' => $f_deptid,
                'r' => isset($item['r']) ? $item['r'] : 0,
                'c' => isset($item['c']) ? $item['c'] : 0,
                'u' => isset($item['u']) ? $item['u'] : 0,
                'd' => isset($item['d']) ? $item['d'] : 0,
                'entry_date' => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->M_akses->bulk_update_submenu($f_deptid, $bulk_data);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses sub menu berhasil diupdate secara bulk',
                'data' => ['total_updated' => count($bulk_data)]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal mengupdate akses sub menu secara bulk'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * PUT: Update sub menu access
     * URL: /menu/akses/submenu/id/1
     * Body: {
     *   "r": 1,
     *   "c": 0,
     *   "u": 1,
     *   "d": 0
     * }
     */
    public function submenu_id_put($id = null)
    {
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        
        // Check if exists
        $exists = $this->M_akses->get_akses_submenu_by_id($id);
        if (!$exists) {
            $this->response([
                'status' => false,
                'message' => 'Data akses sub menu tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        $data = [
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (isset($input['r'])) $data['r'] = $input['r'];
        if (isset($input['c'])) $data['c'] = $input['c'];
        if (isset($input['u'])) $data['u'] = $input['u'];
        if (isset($input['d'])) $data['d'] = $input['d'];

        $result = $this->M_akses->update_akses_submenu($id, $data);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses sub menu berhasil diupdate',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal mengupdate akses sub menu'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * DELETE: Delete sub menu access
     * URL: /menu/akses/submenu/id/1
     */
    public function submenu_id_delete($id = null)
    {
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'ID tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        // Check if exists
        $exists = $this->M_akses->get_akses_submenu_by_id($id);
        if (!$exists) {
            $this->response([
                'status' => false,
                'message' => 'Data akses sub menu tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        $result = $this->M_akses->delete_akses_submenu($id);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses sub menu berhasil dihapus'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menghapus akses sub menu'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * POST: Bulk update sub menu access for department
     * URL: /menu/akses/submenu/bulk
     * Body: {
     *   "f_deptid": 1,
     *   "submenu_access": [
     *     {"id_sub_menu": 1, "r": 1, "c": 1, "u": 1, "d": 1},
     *     {"id_sub_menu": 2, "r": 1, "c": 0, "u": 0, "d": 0}
     *   ]
     * }
     */
    public function submenu_bulk_post()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (empty($input['f_deptid'])) {
            $this->response([
                'status' => false,
                'message' => 'f_deptid harus diisi'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $f_deptid = $input['f_deptid'];
        $submenu_access = isset($input['submenu_access']) ? $input['submenu_access'] : [];
        
        // Prepare bulk data
        $bulk_data = [];
        foreach ($submenu_access as $item) {
            $bulk_data[] = [
                'id_sub_menu' => $item['id_sub_menu'],
                'f_deptid' => $f_deptid,
                'r' => isset($item['r']) ? $item['r'] : 0,
                'c' => isset($item['c']) ? $item['c'] : 0,
                'u' => isset($item['u']) ? $item['u'] : 0,
                'd' => isset($item['d']) ? $item['d'] : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->M_akses->bulk_update_submenu($f_deptid, $bulk_data);
        
        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Akses sub menu berhasil diupdate secara bulk',
                'data' => ['total_updated' => count($bulk_data)]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal mengupdate akses sub menu secara bulk'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ==================== HELPER ENDPOINTS ====================

    /**
     * GET: Test endpoint to verify API is working
     * URL: /menu/akses/test
     */
    public function test_get()
    {
        $this->response([
            'status' => true,
            'message' => 'API Akses Menu is working!',
            'data' => [
                'version' => '1.0',
                'php_version' => PHP_VERSION,
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ], REST_Controller::HTTP_OK);
    }

    /**
     * GET: Get all available menus (for reference)
     * URL: /menu/akses/menus
     */
    public function menus_get()
    {
        $mainmenus = $this->M_akses->get_all_mainmenu();
        
        foreach ($mainmenus as &$menu) {
            $menu->submenus = $this->M_akses->get_all_submenu($menu->id_menu);
        }
        
        $this->response([
            'status' => true,
            'message' => 'Data menu berhasil diambil',
            'data' => $mainmenus
        ], REST_Controller::HTTP_OK);
    }

    /**
     * GET: Get complete access configuration for a department
     * URL: /menu/akses/department/1
     */
    public function department_get($f_deptid = null)
    {
        if ($f_deptid === null) {
            $this->response([
                'status' => false,
                'message' => 'f_deptid tidak boleh kosong'
            ], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $mainmenu_access = $this->M_akses->get_akses_mainmenu($f_deptid);
        $submenu_access = $this->M_akses->get_akses_submenu($f_deptid);
        
        $this->response([
            'status' => true,
            'message' => 'Data akses department berhasil diambil',
            'data' => [
                'f_deptid' => $f_deptid,
                'mainmenu_access' => $mainmenu_access,
                'submenu_access' => $submenu_access
            ]
        ], REST_Controller::HTTP_OK);
    }

}
