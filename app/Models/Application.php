<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;

class Application extends Model implements FromCollection
{
    use HasFactory;

    protected $fillable = ['data'];
    protected $arr = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->arr = $attributes;
    }

    public function collection()
    {
        $q = Application::query();

        if(!empty($this->arr[0])) {
            $q->where('doctor_id', $this->arr[0]);
        }

        if(!empty($this->arr[1])) {
            $q->where('fio', 'like', "%{$this->arr[1]}%");
        }

        if(!empty($this->arr[2])) {
            $q->where('inn', $this->arr[2]);
        }

        if(!empty($this->arr[3])) {
            $q->where('phone', $this->arr[3]);
        }

        if(!empty($this->arr[4])) {
            $q->where('pcr', $this->arr[4]);
        }

        if(!empty($this->arr[5])) {
            $q->where('predvoritelniy_diagnoz', $this->arr[5]);
        }

        if(!empty($this->arr[6])) {
            if($this->arr[6] == 'Новая заявка') {
                $q->where('status', $this->arr[6])->orWhere('status', NULL);
            }
            else {
                $q->where('status', $this->arr[6]);
            }
        }

        if(!empty($this->arr[7])) {
            $explode_date = explode('-', $this->arr[7]);
            $from = Carbon::parse(trim($explode_date[0]))->startOfDay();
            $to = Carbon::parse(trim($explode_date[1]))->endOfDay();
            $q->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
        }

        $all = $q->paginate(10000);

        $data = [];
        foreach ($all as $item) {
            $implode = '';
            if(!empty($item['duchet'])) {
                $arr = json_decode($item['duchet']);
                if(is_array($arr)) {
                    $implode = implode(', ', $arr);
                }
            }
            $implode2 = '';
            if(!empty($item['naznachit_analiz'])) {
                $arr2 = json_decode($item['naznachit_analiz']);
                if(is_array($arr2)) {
                    $implode2 = implode(', ', $arr2);
                }
            }
            $data[] = [
                $item['id'],
                $item['created_at'],
                $item['fio'],
                $item['inn'],
                $item['address'],
                $item['phone'],
                $item['additional_phone'],
                $item['mesto_raboty'],
                $item['doljnost'],
                $item['bolnichniy_list'],
                $item['osmotr'],
                $item['pcr'],
                $item['date_pcr'],
                $item['kt'],
                $item['date_kt'],
                $item['kt_result'],
                $implode,
                $item['percent_porojeniya'],
                $item['ber_ned'],
                $item['epid_okrujenie'],
                $item['ppm'],
                $item['nazvanie_ls'],
                $item['vakcinaciya'],
                $item['date_1_etap'],
                $item['date_2_etap'],
                $item['preparat'],
                $item['saturaciya'],
                $item['temperatura'],
                $item['slabost'],
                $item['rvota_toshnota'],
                $item['diareya'],
                $item['poterya_obonaniya'],
                $item['poterya_vkusa'],
                $item['kashel'],
                $item['zatrudnenoe_dixanie'],
                $item['odishka'],
                $implode2,
                $item['naznachit_kt'],
                $item['dopolnitelno'],
                $item['naznacheni_ls'],
                $item['predvoritelniy_diagnoz'],
                $item['stepen'],
                $item['isxod'],
            ];
        }

        return new Collection([
            [
                '#',
                'Дата выезда',
                'ФИО',
                'ИИН',
                'Адрес проживания',
                'Телефон',
                'Дополнительный телефон',
                'Место работы',
                'Должность',
                'Больничный лист',
                'Осмотр',
                'ПЦР',
                'Дата ПЦР',
                'КТ',
                'Дата КТ',
                'Результат КТ',
                'Д-учет',
                '% поражения',
                'Беременность срок (недель)',
                'Эпид. окружение',
                'Прием постоянных медикаментов',
                'Названия ЛС',
                'Вакцинация',
                'Дата 1 этапа',
                'Дата 2 этапа',
                'Препарат',
                'Сатурация',
                'Температура',
                'Слабость',
                'Рвота тошнота',
                'Диарея',
                'Потеря обоняния',
                'Потеря вкуса',
                'Кашель',
                'Затрудненное дыхание',
                'Одышка',
                'Назначить анализы',
                'Назначить КТ',
                'Дополнительно',
                'Назначены ЛС',
                'Предварительный диагноз',
                'Степень',
                'Исход'
            ],
            $data
        ]);
    }
}
