<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportProductionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, config('constants.access.menu.laporan'))) {
                return abort(404);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $f_epoch = $request->query('from');
        $t_epoch = $request->query('to');
        $from = $request->query('from') ? (new DateTime("@$f_epoch"))->format('Y-m-d H:i:s') : date('Y-m-d', strtotime('today - 29 days')) . ' 00:00:00';
        $to = $request->query('to') ? (new DateTime("@$t_epoch"))->format('Y-m-d H:i:s') : date('Y-m-d') . ' 23:59:59';
        
        $data['stock'] = DetailPesanan::with(['rawMaterial', 'order' => function ($query) use ($from, $to) {
            return $query->where('status', 'final')->whereBetween('created_at', [$from, $to]);
        }])->get()->where('order', '!=', null)->groupBy('rawMaterial.id');

        $data['from'] = $this->convertPHPToMomentFormat($from);
        $data['to'] = $this->convertPHPToMomentFormat($to);

        return view('admin.laporan.produksi', $data);
    }

    public function unduh(Request $request)
    {
        $f_epoch = $request->query('from');
        $t_epoch = $request->query('to');
        $from = $request->query('from') ? (new DateTime("@$f_epoch"))->format('Y-m-d H:i:s') : date('Y-m-d', strtotime('today - 29 days')) . ' 00:00:00';
        $to = $request->query('to') ? (new DateTime("@$t_epoch"))->format('Y-m-d H:i:s') : date('Y-m-d') . ' 23:59:59';
        
        $data['stock'] = DetailPesanan::with(['rawMaterial', 'order' => function ($query) use ($from, $to) {
            return $query->where('status', 'final')->whereBetween('created_at', [$from, $to]);
        }])->get()->where('order', '!=', null)->groupBy('rawMaterial.id');

        $data['from'] = $this->convertPHPToMomentFormat($from);
        $data['to'] = $this->convertPHPToMomentFormat($to);
        $pdf = Pdf::loadView('admin.laporan.unduh', $data);
        return $pdf->stream();
    }

    private function convertPHPToMomentFormat($format)
    {
        $replacements = [
            'd' => 'DD',
            'D' => 'ddd',
            'j' => 'D',
            'l' => 'dddd',
            'N' => 'E',
            'S' => 'o',
            'w' => 'e',
            'z' => 'DDD',
            'W' => 'W',
            'F' => 'MMMM',
            'm' => 'MM',
            'M' => 'MMM',
            'n' => 'M',
            't' => '', // no equivalent
            'L' => '', // no equivalent
            'o' => 'YYYY',
            'Y' => 'YYYY',
            'y' => 'YY',
            'a' => 'a',
            'A' => 'A',
            'B' => '', // no equivalent
            'g' => 'h',
            'G' => 'H',
            'h' => 'hh',
            'H' => 'HH',
            'i' => 'mm',
            's' => 'ss',
            'u' => 'SSS',
            'e' => 'zz', // deprecated since version 1.6.0 of moment.js
            'I' => '', // no equivalent
            'O' => '', // no equivalent
            'P' => '', // no equivalent
            'T' => '', // no equivalent
            'Z' => '', // no equivalent
            'c' => '', // no equivalent
            'r' => '', // no equivalent
            'U' => 'X',
        ];
        $momentFormat = strtr($format, $replacements);
        return $momentFormat;
    }
}
