<table>
    <tr>
        <th></th>
        <td width="15" align="right"><strong>Project Name:</strong></td>
        <td align="left"><strong>{{$projects->name}}</strong></td>
    </tr>
    <tr>
        <th></th>
        <td width="15" align="right"><strong>No Project:</strong></td>
        <td align="left"><strong>{{$projects->no_po}}</strong></td>
    </tr>
    <tr>
        <th></th>
        <td width="15" align="right"><strong>Date:</strong></td>
        <td align="left"><strong>{{date('d M Y', $projects->created_at->timestamp)}}</strong></td>
    </tr>
    <tr>
        <th></th>
        <td width="15" align="right"><strong>Total:</strong></td>
        <td align="left"><strong>@rupiah($projects->total_price)</strong></td>
    </tr>
    <tr>
    </tr>
</table>
<table>
    {{-- <thead> --}}
    <tr height="15">
        <th width="3" align="center" rowspan="2"><strong>No<br></strong></th>
        <th align="center" rowspan="2"><strong>Deskripsi Barang/Jasa/ Software</strong></th>
        <th align="center" colspan="11"><strong>Harga Jual</strong></th>
        <th colspan="8" align="center"><strong>Modal</strong></th>

    </tr>
    <tr height="32">
        <th align="center"><strong>Harga / Unit</strong></th>
        <th align="center"><strong>Total Setelah (PPN)</strong></th>
        <th align="center"><strong>No. Inv</strong></th>
        <th align="center"><strong>Tanggal Inv</strong></th>
        <th align="center"><strong>Harga Per Unit</strong></th>
        <th align="center"><strong>PPN 10%</strong></th>
        <th align="center"><strong>Total Invoice</strong></th>
        <th align="center"><strong>PPH 22 </strong></th>
        <th align="center"><strong>PPH 23 </strong></th>
        <th align="center"><strong>Total Bayar</strong></th>
        <th align="center"><strong>Tanggal Bayar</strong></th>
        <th align="center"><strong>Nama Supplier</strong></th>
        {{-- <th align="center"><strong>Margin</strong></th> --}}
        {{-- <th align="center"><strong>No. Inv</strong></th> --}}
        <th align="center"><strong>Harga Per Unit</strong></th>
        <th align="center"><strong>Tanggal Inv</strong></th>
        <th align="center"><strong>PPN 10%</strong></th>
        <th align="center"><strong>Total Invoice</strong></th>
        <th align="center"><strong>PPH 23</strong></th>
        <th align="center"><strong>Total Bayar</strong></th>
        <th align="center"><strong>Tanggal Bayar</strong></th>
        {{-- <th align="center"><strong>Harga / Unit</strong></th> --}}
    </tr>
    {{-- </thead> --}}
    {{-- <tbody> --}}
    @foreach ($invoices as $item)
    <tr>
        <td align="center">{{$loop->iteration}}</td>
        <td align="center">{{$item->progress_item->name_progress}}</td>
        <td align="right">@rupiah($item->amount_total)</td>
        <td align="right">@rupiah($item->amount_total + ((10 / 100) * $item->amount_total))</td>
        <td align="right">{{$item->invoice_number}}</td>
        <td align="center">{{date('d M Y', $item->created_at->timestamp)}}</td>
        <td align="right">@rupiah($item->amount_total)</td>
        <td align="right">@rupiah((10 / 100) * $item->amount_total)</td>
        <td align="right">@rupiah($item->amount_total + ((10 / 100) * $item->amount_total))</td>
        <td></td>
        <td align="right">@rupiah((2 / 100) * $item->amount_total)</td>
        <td align="right">@rupiah(($item->amount_total + ((10 / 100) * $item->amount_total)) - ((2 / 100) * $item->amount_total))</td>
        <td align="center">-</td>
        @foreach ($item->progress_item->project_cost as $key => $cost)
        @if (!empty($item->progress_item->project_cost))
        @if ($key < 1) {{-- <td align="right">@rupiah($cost->budget_of_quantity)</td> --}} <td align="center">{{$cost->suplier->name}}</td>
            <td align="right">@rupiah($cost->budget_of_quantity)</td>
            <td align="center">{{date('d M Y', $cost->created_at->timestamp)}}</td>
            <td align="center">-</td>
            <td align="right">@rupiah($cost->budget_of_quantity)</td>
            @php
            $checkPPH23 = false;
            @endphp
            @foreach ($cost->tax_project_cost as $tax)
            @if ($tax->tax_id == 1)
            @endif
            @if ($tax->tax_id == 3)
            <td align="right">@rupiah(($tax->percentage / 100) * $cost->budget_of_quantity)</td>
            <td align="right">@rupiah($cost->budget_of_quantity - (($tax->percentage / 100) * $cost->budget_of_quantity))</td>
            @php
            $checkPPH23 = true;
            @endphp
            @endif
            @endforeach
            @if ($checkPPH23 == false)
            <td align="center">-</td>
            <td align="right">@rupiah($cost->budget_of_quantity)</td>
            @endif
            {{-- @foreach ($taxCosts as $tax)
                        @if ($tax->tax_project_cost_id == $cost->id)
                            @if ($tax->tax_id == 3)
                            <td align="right">@rupiah(($tax->percentage  / 100) * $cost->budget_of_quantity)</td>
                            <td align="right">@rupiah($cost->budget_of_quantity - (($tax->percentage  / 100) * $cost->budget_of_quantity))</td>
                            @elseif ($tax->tax_id == 1)
                            @else
                             <td align="center">-</td>
                             <td align="right">@rupiah($cost->budget_of_quantity)</td>
                            @endif
                        @endif
                    @endforeach --}}
            <td align="center">-</td>
            @else
    </tr>
    <tr>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        {{-- <td align="right">@rupiah($cost->budget_of_quantity)</td> --}}
        <td align="center">{{$cost->suplier->name}}</td>
        <td align="right">@rupiah($cost->budget_of_quantity)</td>
        <td align="center">{{date('d M Y', $cost->created_at->timestamp)}}</td>
        <td align="center">-</td>
        <td align="right">@rupiah($cost->budget_of_quantity)</td>
        @php
        $checkPPH23 = false;
        @endphp
        @foreach ($cost->tax_project_cost as $tax)
        @if ($tax->tax_id == 1)
        @endif
        @if ($tax->tax_id == 3)
        <td align="right">@rupiah(($tax->percentage / 100) * $cost->budget_of_quantity)</td>
        <td align="right">@rupiah($cost->budget_of_quantity - (($tax->percentage / 100) * $cost->budget_of_quantity))</td>
        @php
        $checkPPH23 = true;
        @endphp
        @endif
        @endforeach
        @if ($checkPPH23 == false)
        <td align="center">-</td>
        <td align="right">@rupiah($cost->budget_of_quantity)</td>
        @endif
        <td align="center">-</td>
        @endif
        @else
        @endif
        @endforeach
    </tr>
    @endforeach
    <tr>
        <td align="center" colspan="2"><strong>Total</strong></td>
        <td align="right"><strong>@rupiah($projects->total_price)</strong></td>
        <td align="right"><strong>@rupiah(((10 / 100) * $projects->total_price) + $projects->total_price)</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center"><strong>Total</strong></td>
        <td align="right"><strong>@rupiah($projectcarddetails->totalcost)</strong></td>
    </tr>
    {{-- </tbody> --}}
</table>
