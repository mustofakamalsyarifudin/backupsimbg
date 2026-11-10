<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserActivityLogModel;

class Activity extends BaseController
{
    protected UserActivityLogModel $activityModel;

    public function __construct()
    {
        $this->activityModel = new UserActivityLogModel();
    }

    public function index()
    {
        $q = trim((string) $this->request->getGet('q'));
        $level = trim((string) $this->request->getGet('level'));
        $idSppg = trim((string) $this->request->getGet('id_sppg'));
        $module = trim((string) $this->request->getGet('module'));
        $start = trim((string) $this->request->getGet('start'));
        $end = trim((string) $this->request->getGet('end'));

        $builder = $this->activityModel
            ->select('user_activity_logs.*, users.full_name, sppg.sppg_name')
            ->join('users', 'users.id = user_activity_logs.user_id', 'left')
            ->join('sppg', 'sppg.id_sppg = user_activity_logs.id_sppg', 'left');

        if ($q !== '') {
            $builder->groupStart()
                ->like('user_activity_logs.username', $q)
                ->orLike('users.full_name', $q)
                ->orLike('user_activity_logs.activity', $q)
                ->orLike('user_activity_logs.module', $q)
                ->orLike('sppg.sppg_name', $q)
                ->groupEnd();
        }

        $levels = ['super_admin', 'admin', 'kepala', 'gizi', 'keuangan', 'aslap', 'koperasi'];
        if (in_array($level, $levels, true)) {
            $builder->where('user_activity_logs.user_level', $level);
        } else {
            $level = '';
        }

        if ($idSppg !== '') {
            $builder->where('user_activity_logs.id_sppg', $idSppg);
        }

        if ($module !== '') {
            $builder->where('user_activity_logs.module', $module);
        }

        if ($start !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $start)) {
            $builder->where('user_activity_logs.created_at >=', $start . ' 00:00:00');
        } else {
            $start = '';
        }

        if ($end !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $end)) {
            $builder->where('user_activity_logs.created_at <=', $end . ' 23:59:59');
        } else {
            $end = '';
        }

        $db = \Config\Database::connect();
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');

        $today = (int) $db->table('user_activity_logs')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->countAllResults();

        $uniqueToday = (int) $db->table('user_activity_logs')
            ->select('user_id')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->where('user_id IS NOT NULL', null, false)
            ->groupBy('user_id')
            ->countAllResults();

        $loginToday = (int) $db->table('user_activity_logs')
            ->where('created_at >=', $todayStart)
            ->where('created_at <=', $todayEnd)
            ->where('module', 'Autentikasi')
            ->where('activity', 'Login berhasil')
            ->countAllResults();

        $data = [
            'title' => 'Audit Aktivitas User',
            'activities' => $builder
                ->orderBy('user_activity_logs.created_at', 'DESC')
                ->paginate(15),
            'pager' => $this->activityModel->pager,
            'q' => $q,
            'level' => $level,
            'id_sppg' => $idSppg,
            'module' => $module,
            'start' => $start,
            'end' => $end,
            'levels' => $levels,
            'sppgs' => $db->table('sppg')->select('id_sppg, sppg_name')->where('status', 'active')->orderBy('sppg_name', 'ASC')->get()->getResultArray(),
            'modules' => $db->table('user_activity_logs')->select('module')->where('module !=', '')->groupBy('module')->orderBy('module', 'ASC')->get()->getResultArray(),
            'summary' => [
                'today' => $today,
                'unique_today' => $uniqueToday,
                'login_today' => $loginToday,
            ],
        ];

        return view('admin/activity', $data);
    }
}
