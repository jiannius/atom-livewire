<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $filename }}</title>

    <style type="text/css">
        @page {
            margin: 2.75cm 0.75cm 0.75cm;
        }
        /* Base styles */
        * {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-style: normal;
            font-size: 9pt;
            color: #212A33;
        }
        /* global style */
        table { border-collapse: collapse; }
    </style>
</head>
<body>
    <table style="position: fixed; top: -2cm; width: 100%;">
        <tr>
            <td style="width: 1.5cm; padding-right: 0.2cm;">
                <img src="storage/img/logo.svg" style="width: 100%;">
            </td>
            <td style="font-size: 20pt;">
                {{ config('app.name') }}
            </td>
            <td style="text-align: right; font-size: 20pt; font-weight: 700;">
                {{ strtoupper($doc) }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom: 1cm; margin-top: 0.5cm;">
        <table style="width: 100%;">
            <tr>
                <td style="padding-right: 0.3cm; vertical-align: top;">
                    <div style="margin-bottom: 0.5cm;">
                        <div style="font-weight: 700; margin-bottom: 0.1cm;">
                            From
                        </div>
                        Jiannius Technologies Sdn Bhd<br>
                        LG1-2, Seri Gembira Avenue, 6, Jalan Senang Ria Happy Garden, Kuchai Lama, 58200 Kuala Lumpur, Malaysia.
                    </div>

                    <div style="font-weight: 700; margin-bottom: 0.1cm;">
                        Bill To
                    </div>
                    {{ $payment->order->user->name }}<br>
                    {{ $payment->order->user->address ?? '' }}
                </td>
                <td style="padding-left: 0.3cm; vertical-align: top;">
                    <div style="font-weight: 700; margin-bottom: 0.1cm;">
                        Details
                    </div>
                    <table style="width: 100%">
                        @if ($doc === 'invoice')
                            <tr>
                                <td>Invoice Number:</td>
                                <td style="text-align: right;">{{ $payment->order->number }}</td>
                            </tr>
                        @elseif ($doc === 'receipt')
                            <tr>
                                <td>Receipt Number:</td>
                                <td style="text-align: right;">{{ $payment->number }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Issue Date:</td>
                            <td style="text-align: right;">{{ $payment->created_at->toFormattedDateString() }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div>
        <div style="font-size: 11pt; margin-bottom: 0.5cm;">
            Subscription charges
        </div>

        <table style="width: 100%;">
            <thead>
                <tr>
                    <td style="font-weight: 700; width: 80%; padding-bottom: 0.2cm; border-bottom: 1px solid #aaa;">
                        Description
                    </td>
                    <td style="font-weight: 700; text-align: right; padding-bottom: 0.2cm; border-bottom: 1px solid #aaa;">
                        Amount
                    </td>
                </tr>
            </thead>

            <tbody>
                @foreach ($payment->order->items as $item)
                    <tr>
                        <td style="width: 80%; padding: 0.2cm 0; vertical-align: top;">
                            {{ $item->name }}
                        </td>
                        <td style="text-align: right; padding: 0.2cm 0; vertical-align: top;">
                            {{ currency($item->grand_total, $item->currency) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td style="text-align: right; width: 80%; font-size: 14pt; padding: 0.2cm 0; border-top: 1px solid #aaa;">
                        Grand Total
                    </td>
                    <td style="text-align: right; font-size: 14pt; padding: 0.2cm 0; border-top: 1px solid #aaa;">
                        {{ currency($payment->amount, $payment->currency) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>