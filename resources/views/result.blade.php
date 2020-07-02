<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CSV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Результат</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Отправитель</th>
                    <th scope="col">Получатель</th>
                    <th scope="col">Тип документа</th>
                    <th scope="col">Плательщик</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Сумма</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{$payment->sender}}</td>
                        <td>{{$payment->receiver}}</td>
                        <td>{{$payment->doc_type}}</td>
                        <td>{{$payment->payer}}</td>
                        <td>{{$payment->count}}</td>
                        <td>{{$payment->sum}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Нет результатов</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="4"><strong>Итого</strong></td>
                    <td colspan="2"><strong>{{$sum ?? '0'}}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-4">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Сумма {{\App\Payment::PAY_S}}</th>
                    <th scope="col">Сумма {{\App\Payment::PAY_R}}</th>
                    <th scope="col">Итого</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$sumS}}</td>
                    <td>{{$sum - $sumS}}</td>
                    <td>{{$sum}}</td>
                </tr>
                <tr>
                    <th colspan="3">Разница между суммами</th>
                </tr>
                <tr>
                    <td colspan="3">{{round(abs($sum - 2 * $sumS) / $sumS * 100, 2)}}%</td>
                </tr>
                </tbody>
            </table>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Типы документов</th>
                    <th scope="col">Кол-во, %</th>
                </tr>
                </thead>
                <tbody>
                @forelse($docTypes as $type => $count)
                    <tr>
                        <td>{{$type}}</td>
                        <td>{{round($count / $countDoc * 100, 2)}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">--</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
