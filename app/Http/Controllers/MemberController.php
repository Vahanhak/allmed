<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Applicationstatuse;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function login(Request $request)
    {
        if (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'operator') {
            return redirect('/operator');
        } elseif (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'doctor') {
            return redirect('/dashboard/doctor');
        } elseif (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'nurse') {
            return redirect('/nurse');
        } elseif (isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'admin') {
            return redirect('/admin');
        }

        $member = $request->all();

        if (empty($member['username']) || empty($member['password'])) {
            return redirect('/');
        }

        $username = trim($member['username']);
        $password = trim($member['password']);

        $user = DB::table('members')->where('username', $username)
            ->where('password', $password)->first();

        if (!$user) {
            return redirect('/')->with('status', 'Ошибка: username/password');
        }

        setcookie('user_id', $user->id, time() + 3600000000);
        setcookie('user_role', $user->role, time() + 360000000);
        if ($user->role === 'admin') {
            return redirect('/admin');
        } else if ($user->role === 'doctor') {
            return redirect('/dashboard/doctor');
        } else if ($user->role === 'nurse') {
            return redirect('/nurse');
        } else if ($user->role === 'operator') {
            return redirect('/operator');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = DB::table('members')->where('username', '<>', 'admin')->get();

        return view('admin', ['data' => $data]);
    }

    public function doctor(Request $request, $id = null)
    {
        $data = $request->all();

        if (isset($data['fio']) && isset($data['inn'])) {
            if (is_null($id)) {
                $doctor = new Application;
            } else {
                $doctor = Application::find($id);
            }
            $duchet = '';
            if (!empty($request->input('duchet'))) {
                $duchet = json_encode($request->input('duchet'));
            }
            $naznachit_analiz = '';
            if (!empty($request->input('naznachit_analiz'))) {
                $naznachit_analiz = json_encode($request->input('naznachit_analiz'));
            }
            $doctor->doctor_id = $_COOKIE['user_id'];
            $doctor->fio = $request->input('fio');
            $doctor->inn = $request->input('inn');
            $doctor->address = $request->input('address');
            $doctor->phone = $request->input('phone');
            $doctor->additional_phone = $request->input('additional_phone');
            $doctor->mesto_raboty = $request->input('mesto_raboty');
            $doctor->doljnost = $request->input('doljnost');
            $doctor->bolnichniy_list = $request->input('bolnichniy_list');
            $doctor->osmotr = $request->input('osmotr');
            $doctor->pcr = $request->input('pcr');
            $doctor->date_pcr = $request->input('date_pcr');
            $doctor->kt = $request->input('kt');
            $doctor->kt_result = $request->input('kt_result');
            $doctor->date_kt = $request->input('date_kt');
            $doctor->percent_porojeniya = $request->input('percent_porojeniya');
            $doctor->kt_input_drugoe = $request->input('kt_input_drugoe');
            $doctor->duchet = $duchet;
            $doctor->ber_ned = $request->input('ber_ned');
            $doctor->epid_okrujenie = $request->input('epid_okrujenie');
            $doctor->ppm = $request->input('ppm');
            $doctor->nazvanie_ls = $request->input('nazvanie_ls');
            $doctor->saturaciya = $request->input('saturaciya');
            $doctor->temperatura = $request->input('temperatura');
            $doctor->slabost = $request->input('slabost');
            $doctor->rvota_toshnota = $request->input('rvota_toshnota');
            $doctor->diareya = $request->input('diareya');
            $doctor->poterya_obonaniya = $request->input('poterya_obonaniya');
            $doctor->poterya_vkusa = $request->input('poterya_vkusa');
            $doctor->kashel = $request->input('kashel');
            $doctor->zatrudnenoe_dixanie = $request->input('zatrudnenoe_dixanie');
            $doctor->odishka = $request->input('odishka');
            $doctor->naznachit_analiz = $naznachit_analiz;
            $doctor->naznachit_kt = $request->input('naznachit_kt');
            $doctor->dopolnitelno = $request->input('dopolnitelno');
            $doctor->naznacheni_ls = $request->input('naznacheni_ls');
            $doctor->vakcinaciya = $request->input('vakcinaciya');
            $doctor->date_1_etap = $request->input('date_1_etap');
            $doctor->date_2_etap = $request->input('date_2_etap');
            $doctor->preparat = $request->input('preparat');
            $doctor->predvoritelniy_diagnoz = $request->input('predvoritelniy_diagnoz');
            $doctor->stepen = $request->input('stepen');
            $doctor->isxod = $request->input('isxod');
            if(!is_null($id)) {
                $doctor->route_sheet_status = 'Выполнена';
                $doctor->status = null;
            }
            $doctor->save();
            return redirect('/dashboard/doctor')->with('status', 'Добавлено');
        }

        $app = [];
        $app['bolnichniy_list'] = null;
        $app['osmotr'] = null;
        $app['pcr'] = null;
        $app['kt'] = null;
        $app['kt_result'] = null;
        $app['ppm'] = null;
        $app['vakcinaciya'] = null;
        $app['preparat'] = null;
        $app['slabost'] = null;
        $app['rvota_toshnota'] = null;
        $app['diareya'] = null;
        $app['poterya_obonaniya'] = null;
        $app['poterya_vkusa'] = null;
        $app['kashel'] = null;
        $app['zatrudnenoe_dixanie'] = null;
        $app['naznachit_kt'] = null;
        $app['predvoritelniy_diagnoz'] = null;
        $app['stepen'] = null;
        $app['isxod'] = null;
        $app['odishka'] = null;
        if (!is_null($id)) {
            $app = Application::find($id);
        }

        return view('doctor', [
            'app' => $app,
            'id' => $id ?? null
        ]);
    }

    public function dashboard()
    {
        $data = Application::where('is_route_sheet', 1)
            ->where('doctor_id', $_COOKIE['user_id'])
            ->where('route_sheet_status', 'Новая')
            ->orderByDesc('srochno')
            ->orderBy('created_at')
            ->get(['id', 'fio', 'address', 'srochno', 'created_at']);

        return view('dashboard', ['data' => $data]);
    }

    /**
     * @return string[]
     */
    private function months(): array
    {
        return [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь'
        ];
    }

    /**
     * @return string[]
     */
    private function days(): array
    {
        return [
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресенье'
        ];
    }

    public function history()
    {
        return view('history', [
            'month' => $this->months()[date("n")] . '/' . date("Y"),
            'day' => $this->days()[date("N")] . ', ' . date("d/m/Y")
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function history_month(Request $request): array
    {
        $all = $request->all();

        $data_count = 0;
        $canceled = 0;
        $invalid_address = 0;
        $already_hospitalized = 0;
        $refusal_inspect = 0;
        $another_mo_mb = 0;
        $processed = 0;

        if ($all['month'] === 'now') {
            $app = Application::where('doctor_id', $_COOKIE['user_id'])
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->get([
                    'id', 'status', 'route_sheet_status', 'canceled_status'
                ]);
        }
        else {
            $ex = explode('/', $all['month']);
            $month = array_search($ex[0], $this->months());
            $app = Application::where('doctor_id', $_COOKIE['user_id'])
                ->whereYear('created_at', Carbon::createFromFormat("Y", $ex[1])->year)
                ->whereMonth('created_at', Carbon::createFromFormat("m", $month)->month)
                ->get([
                    'id', 'status', 'route_sheet_status', 'canceled_status'
                ]);
        }
        if ($app) {
            $data_count = count($app);
        }

        foreach ($app as $item) {
            if ($item->status == 'Отклонена' || $item->route_sheet_status == 'Отменена') {
                $canceled += 1;
                if ($item->canceled_status === 'Некорректный адрес') {
                    $invalid_address += 1;
                }
                if ($item->canceled_status === 'Уже госпитализирован') {
                    $already_hospitalized += 1;
                }
                if ($item->canceled_status === 'Отказ от осмотра') {
                    $refusal_inspect += 1;
                }
                if ($item->canceled_status === 'Осмотр другой МО или МБ') {
                    $another_mo_mb += 1;
                }
            }
            if ($item->status == 'Обработана' || $item->route_sheet_status == 'Выполнена') {
                $processed += 1;
            }
        }

        return [
            'data_count' => $data_count,
            'canceled' => $canceled,
            'invalid_address' => $invalid_address,
            'already_hospitalized' => $already_hospitalized,
            'refusal_inspect' => $refusal_inspect,
            'another_mo_mb' => $another_mo_mb,
            'processed' => $processed
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function history_day(Request $request): array
    {
        $all = $request->all();

        if ($all['day'] === 'now') {
            $app = Application::where('doctor_id', $_COOKIE['user_id'])
                ->whereDate('created_at', Carbon::today())
//                ->where(function ($query) {
//                    $query->where('route_sheet_status', 'Выполнена')
//                        ->orWhere('route_sheet_status', 'Отменена');
//                })
                ->get(['id', 'fio', 'predvoritelniy_diagnoz', 'address', 'route_sheet_status', 'canceled_status']);
        }
        else {
            $date = explode(', ', $all['day']);
            $ex = explode('/', $date[1]);
            $app = Application::where('doctor_id', $_COOKIE['user_id'])
                ->whereYear('created_at', Carbon::createFromFormat("Y", $ex[2])->year)
                ->whereMonth('created_at', Carbon::createFromFormat("m", $ex[1])->month)
                ->whereDay('created_at', Carbon::createFromFormat("d", $ex[0])->day)
//                ->where(function ($query) {
//                    $query->where('route_sheet_status', 'Выполнена')
//                        ->orWhere('route_sheet_status', 'Отменена');
//                })
                ->get(['id', 'fio', 'predvoritelniy_diagnoz', 'address', 'route_sheet_status', 'canceled_status']);
        }

        return [
            'app' => $app,
            'app_count' => count($app)
        ];
    }

    /**
     * @param Request $request
     * @param $c
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function operator(Request $request, $c = null)
    {
        $filter = $request->all();
        $search = '';
        $data = DB::table('members')->where('role', 'doctor')->get();

        $q = Application::query();

        if (!empty($filter['vrach'])) {
            $q->where('doctor_id', $filter['vrach']);
            $search .= '&vrach=' . $filter['vrach'];
        }

        if (!empty($filter['fio_pacient'])) {
            $q->where('fio', 'like', "%{$filter['fio_pacient']}%");
            $search .= '&fio_pacient=' . $filter['fio_pacient'];
        }

        if (!empty($filter['iin_pacient'])) {
            $q->where('inn', $filter['iin_pacient']);
            $search .= '&iin_pacient=' . $filter['iin_pacient'];
        }

        if (!empty($filter['phone_pacient'])) {
            $q->where('phone', $filter['phone_pacient']);
            $search .= '&phone_pacient=' . $filter['phone_pacient'];
        }

        if (!empty($filter['result_pcr'])) {
            $q->where('pcr', $filter['result_pcr']);
            $search .= '&result_pcr=' . $filter['result_pcr'];
        }

        if (!empty($filter['diagnoz_kvi'])) {
            $q->where('predvoritelniy_diagnoz', $filter['diagnoz_kvi']);
            $search .= '&diagnoz_kvi=' . $filter['diagnoz_kvi'];
        }

        if (!empty($filter['status_zayavki'])) {
            if ($filter['status_zayavki'] == 'Новая заявка') {
                $q->where('status', $filter['status_zayavki'])->orWhere('status', NULL);
            } else {
                $q->where('status', $filter['status_zayavki']);
            }
            $search .= '&status_zayavki=' . $filter['status_zayavki'];
        }

        if (!empty($filter['filter_date'])) {
            $explode_date = explode('-', $filter['filter_date']);
            $from = Carbon::parse(trim($explode_date[0]))->startOfDay();
            $to = Carbon::parse(trim($explode_date[1]))->endOfDay();
            $q->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
            $search .= '&filter_date=' . $filter['filter_date'];
        }

        if (!empty($filter['srochno'])) {
            $q->where('srochno', $filter['srochno']);
            $search .= '&srochno=' . $filter['srochno'];
        }

        $q->where('is_route_sheet', 0)
            ->orWhere(function($query) {
                $query->where('is_route_sheet', 1)
                    ->where('route_sheet_status', 'Выполнена');
            });

        $applications = $q->paginate(20);

        $pages = ceil($applications->total() / $applications->perPage());

        $request->flashOnly(['vrach',
            'fio_pacient',
            'iin_pacient',
            'phone_pacient',
            'result_pcr',
            'diagnoz_kvi',
            'filter_date',
            'status_zayavki',
            'srochno']);

        $doctors = [];
        foreach ($data as $item) {
            $doctors[$item->id] = $item->fio;
        }

        return view('operator', ['data' => [
            'doctors' => $doctors,
            'applications' => $applications,
            'pages' => $pages,
            'search' => $search
        ]]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = Application::where('id', $id)->first();

        return view('edit', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if (isset($data['fio']) && isset($data['inn'])) {
            $duchet = '';
            if (!empty($request->input('duchet'))) {
                $duchet = json_encode($request->input('duchet'));
            }
            $naznachit_analiz = '';
            if (!empty($request->input('naznachit_analiz'))) {
                $naznachit_analiz = json_encode($request->input('naznachit_analiz'));
            }
            $doctor = Application::where('id', $id)->first();
            $doctor->fio = $request->input('fio');
            $doctor->inn = $request->input('inn');
            $doctor->address = $request->input('address');
            $doctor->phone = $request->input('phone');
            $doctor->additional_phone = $request->input('additional_phone');
            $doctor->mesto_raboty = $request->input('mesto_raboty');
            $doctor->doljnost = $request->input('doljnost');
            $doctor->bolnichniy_list = $request->input('bolnichniy_list');
            $doctor->osmotr = $request->input('osmotr');
            $doctor->pcr = $request->input('pcr');
            $doctor->date_pcr = $request->input('date_pcr');
            $doctor->kt = $request->input('kt');
            $doctor->kt_result = $request->input('kt_result');
            $doctor->date_kt = $request->input('date_kt');
            $doctor->percent_porojeniya = $request->input('percent_porojeniya');
            $doctor->kt_input_drugoe = $request->input('kt_input_drugoe');
            $doctor->duchet = $duchet;
            $doctor->ber_ned = $request->input('ber_ned');
            $doctor->epid_okrujenie = $request->input('epid_okrujenie');
            $doctor->ppm = $request->input('ppm');
            $doctor->nazvanie_ls = $request->input('nazvanie_ls');
            $doctor->saturaciya = $request->input('saturaciya');
            $doctor->temperatura = $request->input('temperatura');
            $doctor->slabost = $request->input('slabost');
            $doctor->rvota_toshnota = $request->input('rvota_toshnota');
            $doctor->diareya = $request->input('diareya');
            $doctor->poterya_obonaniya = $request->input('poterya_obonaniya');
            $doctor->poterya_vkusa = $request->input('poterya_vkusa');
            $doctor->kashel = $request->input('kashel');
            $doctor->zatrudnenoe_dixanie = $request->input('zatrudnenoe_dixanie');
            $doctor->odishka = $request->input('odishka');
            $doctor->naznachit_analiz = $naznachit_analiz;
            $doctor->naznachit_kt = $request->input('naznachit_kt');
            $doctor->dopolnitelno = $request->input('dopolnitelno');
            $doctor->naznacheni_ls = $request->input('naznacheni_ls');
            $doctor->vakcinaciya = $request->input('vakcinaciya');
            $doctor->date_1_etap = $request->input('date_1_etap');
            $doctor->date_2_etap = $request->input('date_2_etap');
            $doctor->preparat = $request->input('preparat');
            $doctor->predvoritelniy_diagnoz = $request->input('predvoritelniy_diagnoz');
            $doctor->stepen = $request->input('stepen');
            $doctor->isxod = $request->input('isxod');
            $doctor->status = $request->input('status');
            $doctor->save();
            return redirect('/operator')->with('status', 'Успешно обновлено');
        }
    }

    public function exportFile(Request $request)
    {
        $filter = $request->all();
        $data = [];
        $data[] = $filter["vrach"] ?? '';
        $data[] = $filter["fio"] ?? '';
        $data[] = $filter["inn"] ?? '';
        $data[] = $filter["phone"] ?? '';
        $data[] = $filter["pcr"] ?? '';
        $data[] = $filter["predvoritelniy_diagnoz"] ?? '';
        $data[] = $filter["status"] ?? '';
        $data[] = $filter["filter_date"] ?? '';

        return Excel::download(new Application($data), 'app-list.xlsx');
    }

    public function nurse(Request $request, $c = null)
    {
        $filter = $request->all();
        $search = '';
        $member = Member::find($_COOKIE['user_id']);

        $q = Application::query();

        if (!empty($filter['fio_pacient'])) {
            $q->where('fio', 'like', "%{$filter['fio_pacient']}%");
            $search .= '&fio_pacient=' . $filter['fio_pacient'];
        }

        if (!empty($filter['iin_pacient'])) {
            $q->where('inn', $filter['iin_pacient']);
            $search .= '&iin_pacient=' . $filter['iin_pacient'];
        }

        if (!empty($filter['phone_pacient'])) {
            $q->where('phone', $filter['phone_pacient']);
            $search .= '&phone_pacient=' . $filter['phone_pacient'];
        }

        if (!empty($filter['filter_date'])) {
            $explode_date = explode('-', $filter['filter_date']);
            $from = Carbon::parse(trim($explode_date[0]))->startOfDay();
            $to = Carbon::parse(trim($explode_date[1]))->endOfDay();
            $q->whereDate('applications.created_at', '>=', $from)
                ->whereDate('applications.created_at', '<=', $to);
            $search .= '&filter_date=' . $filter['filter_date'];
        }

        $q->where('doctor_id', $member['doctor_id'])
            ->where(function ($query) {
                $query->where('naznachit_kt', 'Да')
                    ->orWhere('naznachit_analiz', '<>', '');
            });

        $data = $q->get([
            'applications.id',
            'inn',
            'fio',
            'phone',
            'address',
            'applications.created_at',
            'naznachit_kt',
            'naznachit_analiz'
        ]);

        $query = Applicationstatuse::query();
        $query->leftJoin('applications', 'applications.id', '=', 'application_statuses.application_id');
        $query->where('doctor_id', $member['doctor_id']);

        $all = $query->get([
            'application_statuses.application_id',
            'application_statuses.analysis',
            'application_statuses.results',
            'application_statuses.status'
        ]);
        $all_data = [];
        foreach ($all as $value) {
            $all_data[$value->application_id . $value->analysis] = [
                'results' => $value->results,
                'status' => $value->status
            ];
        }

        $applications = [];
        foreach ($data as $item) {
            if (!empty($item->naznachit_analiz)) {
                $naznachit_analiz = json_decode($item->naznachit_analiz);
                foreach ($naznachit_analiz as $na) {
                    $applications[] = [
                        'id' => $item->id,
                        'inn' => $item->inn,
                        'fio' => $item->fio,
                        'phone' => $item->phone,
                        'address' => $item->address,
                        'created_at' => $item->created_at,
                        'name' => $na,
                        'results' => !empty($all_data[$item->id . $na]) ? $all_data[$item->id . $na]['results'] : null,
                        'status' => !empty($all_data[$item->id . $na]) ? $all_data[$item->id . $na]['status'] : null
                    ];
                }
            }
            if ($item->naznachit_kt == 'Да') {
                $applications[] = [
                    'id' => $item->id,
                    'inn' => $item->inn,
                    'fio' => $item->fio,
                    'phone' => $item->phone,
                    'address' => $item->address,
                    'created_at' => $item->created_at,
                    'name' => 'КТ',
                    'results' => !empty($all_data[$item->id . 'КТ']) ? $all_data[$item->id . 'КТ']['results'] : null,
                    'status' => !empty($all_data[$item->id . 'КТ']) ? $all_data[$item->id . 'КТ']['status'] : null
                ];
            }
        }

        if (!empty($filter['status_zayavki'])) {
            $arr = [];
            foreach ($applications as $app) {
                if ($filter['status_zayavki'] == 'Новая' && ($app['status'] == 'Новая' || $app['status'] == null)) {
                    $arr[] = $app;
                } else if ($app['status'] == $filter['status_zayavki']) {
                    $arr[] = $app;
                }
            }
            $applications = $arr;
        }

        $request->flashOnly([
            'fio_pacient',
            'iin_pacient',
            'phone_pacient',
            'status_zayavki',
            'filter_date'
        ]);

        return view('nurse', ['data' => [
            'applications' => $applications,
            'total' => count($applications),
            'search' => $search
        ]]);
    }

    public function application_management(Request $request)
    {
        $data = $request->all();
        $app = Application::where('id', $data['id'])->first();

        return $app;
    }

    public function application_status(Request $request)
    {
        $data = $request->all();
        $app = Application::find($data['id']);
        $app->route_sheet_status = 'Отменена';
        $app->canceled_status = $data['txt'];
        $app->save();

        return 'ok';
    }

    public function route_sheet(Request $request, $c = null)
    {
        $filter = $request->all();
        $search = '';
        $data = DB::table('members')->where('role', 'doctor')->get();

        $q = Application::query();

        $q->where('is_route_sheet', 1);

        if (!empty($filter['vrach'])) {
            $q->where('doctor_id', $filter['vrach']);
            $search .= '&vrach=' . $filter['vrach'];
        }

        if (!empty($filter['fio_pacient'])) {
            $q->where('fio', 'like', "%{$filter['fio_pacient']}%");
            $search .= '&fio_pacient=' . $filter['fio_pacient'];
        }

        if (!empty($filter['iin_pacient'])) {
            $q->where('inn', $filter['iin_pacient']);
            $search .= '&iin_pacient=' . $filter['iin_pacient'];
        }

        if (!empty($filter['phone_pacient'])) {
            $q->where('phone', $filter['phone_pacient']);
            $search .= '&phone_pacient=' . $filter['phone_pacient'];
        }

        if (!empty($filter['status_zayavki'])) {
            if ($filter['status_zayavki'] == 'Новая') {
                $q->where(function ($query) {
                    $query->where('route_sheet_status', 'Новая')
                        ->orWhere('route_sheet_status', null);
                });
            } else {
                $q->where('route_sheet_status', $filter['status_zayavki']);
            }
            $search .= '&status_zayavki=' . $filter['status_zayavki'];
        }

        if (!empty($filter['srochno'])) {
            if($filter['srochno'] == 1000) {
                $q->where('srochno', 0);
            }
            else {
                $q->where('srochno', $filter['srochno']);
            }
            $search .= '&srochno=' . $filter['srochno'];
        }

        if (!empty($filter['filter_date'])) {
            $explode_date = explode('-', $filter['filter_date']);
            $from = Carbon::parse(trim($explode_date[0]))->startOfDay();
            $to = Carbon::parse(trim($explode_date[1]))->endOfDay();
            $q->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
            $search .= '&filter_date=' . $filter['filter_date'];
        }

        $applications = $q->paginate(20);

        $pages = ceil($applications->total() / $applications->perPage());

        $request->flashOnly(['vrach',
            'fio_pacient',
            'iin_pacient',
            'phone_pacient',
            'filter_date',
            'status_zayavki',
            'srochno']);

        $doctors = [];
        foreach ($data as $item) {
            $doctors[$item->id] = $item->fio;
        }

        return view('route_sheet', ['data' => [
            'doctors' => $doctors,
            'applications' => $applications,
            'pages' => $pages,
            'search' => $search
        ]]);
    }

    public function add_route_sheet()
    {
        return view('add_route_sheet', [
            'doctors' => Member::where('role', 'doctor')->get(['id', 'fio'])
        ]);
    }

    public function add_route_sheet_form(Request $request)
    {
        $doctor = new Application;
        $duchet = '';
        if (!empty($request->input('duchet'))) {
            $duchet = json_encode($request->input('duchet'));
        }
        $naznachit_analiz = '';
        if (!empty($request->input('naznachit_analiz'))) {
            $naznachit_analiz = json_encode($request->input('naznachit_analiz'));
        }
        $doctor->doctor_id = $request->input('doctor_id');
        $doctor->fio = $request->input('fio');
        $doctor->inn = $request->input('inn');
        $doctor->address = $request->input('address');
        $doctor->phone = $request->input('phone');
        $doctor->additional_phone = $request->input('additional_phone');
        $doctor->mesto_raboty = $request->input('mesto_raboty');
        $doctor->doljnost = $request->input('doljnost');
        $doctor->bolnichniy_list = $request->input('bolnichniy_list');
        $doctor->osmotr = $request->input('osmotr');
        $doctor->pcr = $request->input('pcr');
        $doctor->date_pcr = $request->input('date_pcr');
        $doctor->kt = $request->input('kt');
        $doctor->kt_result = $request->input('kt_result');
        $doctor->date_kt = $request->input('date_kt');
        $doctor->percent_porojeniya = $request->input('percent_porojeniya');
        $doctor->kt_input_drugoe = $request->input('kt_input_drugoe');
        $doctor->duchet = $duchet;
        $doctor->ber_ned = $request->input('ber_ned');
        $doctor->epid_okrujenie = $request->input('epid_okrujenie');
        $doctor->ppm = $request->input('ppm');
        $doctor->nazvanie_ls = $request->input('nazvanie_ls');
        $doctor->saturaciya = $request->input('saturaciya');
        $doctor->temperatura = $request->input('temperatura');
        $doctor->slabost = $request->input('slabost');
        $doctor->rvota_toshnota = $request->input('rvota_toshnota');
        $doctor->diareya = $request->input('diareya');
        $doctor->poterya_obonaniya = $request->input('poterya_obonaniya');
        $doctor->poterya_vkusa = $request->input('poterya_vkusa');
        $doctor->kashel = $request->input('kashel');
        $doctor->zatrudnenoe_dixanie = $request->input('zatrudnenoe_dixanie');
        $doctor->odishka = $request->input('odishka');
        $doctor->naznachit_analiz = $naznachit_analiz;
        $doctor->naznachit_kt = $request->input('naznachit_kt');
        $doctor->dopolnitelno = $request->input('dopolnitelno');
        $doctor->naznacheni_ls = $request->input('naznacheni_ls');
        $doctor->vakcinaciya = $request->input('vakcinaciya');
        $doctor->date_1_etap = $request->input('date_1_etap');
        $doctor->date_2_etap = $request->input('date_2_etap');
        $doctor->preparat = $request->input('preparat');
        $doctor->predvoritelniy_diagnoz = $request->input('predvoritelniy_diagnoz');
        $doctor->stepen = $request->input('stepen');
        $doctor->is_route_sheet = 1;
        $doctor->isxod = $request->input('isxod');
        $doctor->srochno = $request->input('srochno');
        $doctor->route_sheet_status = 'Новая';
        $doctor->save();

        return redirect('/operator/route/sheet');
    }

    public function edit_route_sheet(Request $request, $id)
    {
        $data = Application::where('id', $id)->first();

        return view('edit_route_sheet', [
            'data' => $data,
            'doctors' => Member::where('role', 'doctor')->get(['id', 'fio'])
        ]);
    }

    public function edit_route_sheet_update(Request $request, $id)
    {
        $doctor = Application::find($id);
        $duchet = '';
        if (!empty($request->input('duchet'))) {
            $duchet = json_encode($request->input('duchet'));
        }
        $naznachit_analiz = '';
        if (!empty($request->input('naznachit_analiz'))) {
            $naznachit_analiz = json_encode($request->input('naznachit_analiz'));
        }
        $doctor->doctor_id = $request->input('doctor_id');
        $doctor->fio = $request->input('fio');
        $doctor->inn = $request->input('inn');
        $doctor->address = $request->input('address');
        $doctor->phone = $request->input('phone');
        $doctor->additional_phone = $request->input('additional_phone');
        $doctor->mesto_raboty = $request->input('mesto_raboty');
        $doctor->doljnost = $request->input('doljnost');
        $doctor->bolnichniy_list = $request->input('bolnichniy_list');
        $doctor->osmotr = $request->input('osmotr');
        $doctor->pcr = $request->input('pcr');
        $doctor->date_pcr = $request->input('date_pcr');
        $doctor->kt = $request->input('kt');
        $doctor->kt_result = $request->input('kt_result');
        $doctor->date_kt = $request->input('date_kt');
        $doctor->percent_porojeniya = $request->input('percent_porojeniya');
        $doctor->kt_input_drugoe = $request->input('kt_input_drugoe');
        $doctor->duchet = $duchet;
        $doctor->ber_ned = $request->input('ber_ned');
        $doctor->epid_okrujenie = $request->input('epid_okrujenie');
        $doctor->ppm = $request->input('ppm');
        $doctor->nazvanie_ls = $request->input('nazvanie_ls');
        $doctor->saturaciya = $request->input('saturaciya');
        $doctor->temperatura = $request->input('temperatura');
        $doctor->slabost = $request->input('slabost');
        $doctor->rvota_toshnota = $request->input('rvota_toshnota');
        $doctor->diareya = $request->input('diareya');
        $doctor->poterya_obonaniya = $request->input('poterya_obonaniya');
        $doctor->poterya_vkusa = $request->input('poterya_vkusa');
        $doctor->kashel = $request->input('kashel');
        $doctor->zatrudnenoe_dixanie = $request->input('zatrudnenoe_dixanie');
        $doctor->odishka = $request->input('odishka');
        $doctor->naznachit_analiz = $naznachit_analiz;
        $doctor->naznachit_kt = $request->input('naznachit_kt');
        $doctor->dopolnitelno = $request->input('dopolnitelno');
        $doctor->naznacheni_ls = $request->input('naznacheni_ls');
        $doctor->vakcinaciya = $request->input('vakcinaciya');
        $doctor->date_1_etap = $request->input('date_1_etap');
        $doctor->date_2_etap = $request->input('date_2_etap');
        $doctor->preparat = $request->input('preparat');
        $doctor->predvoritelniy_diagnoz = $request->input('predvoritelniy_diagnoz');
        $doctor->stepen = $request->input('stepen');
        $doctor->is_route_sheet = 1;
        $doctor->route_sheet_status = $request->input('route_sheet_status');
        $doctor->isxod = $request->input('isxod');
        $doctor->srochno = $request->input('srochno');
        $doctor->save();

        return redirect('/operator/route/sheet');
    }

    public function application_statuses(Request $request)
    {
        $data = $request->all();
        $app = DB::table('application_statuses')
            ->where('application_id', $data['id'])
            ->where('analysis', $data['txt'])
            ->first();

        if (!$app) {
            $app_status = new Applicationstatuse;
            $app_status->application_id = $data['id'];
            $app_status->analysis = $data['txt'];
            $app_status->results = $data['result'];
            $app_status->status = $data['status'];
            $app_status->save();
        } else {
            DB::table('application_statuses')
                ->where('application_id', $data['id'])
                ->where('analysis', $data['txt'])
                ->update([
                    'application_id' => $data['id'],
                    'analysis' => $data['txt'],
                    'results' => $data['result'],
                    'status' => $data['status']
                ]);
        }

        return 'ok';
    }
}
