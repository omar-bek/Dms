<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>{{ $document->name }}</title>
    <style>
        body {
            font-family: 'AE_AlMohanad', sans-serif;
            direction: rtl;
            text-align: right;
        }

        h3 {
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .signature-table td {
            text-align: {{ $document->signature->count() == 1 ? 'left' : 'center' }};
            vertical-align: top;
            width: 50%;
        }

        .signature img {
            width: 60px;
            height: 60px;
        }

        .created-info {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div>
        {!! clean_html($document->content) !!}
    </div>

    @if ($document->signature->isNotEmpty())
        <table class="signature-table">
            <tr>
                @if ($document->signature->count() == 1)
                    @php $signature = $document->signature->first(); @endphp
                    <td style="text-align:left">
                        @if ($signature->notes)
                            <p>{{ $signature->notes }}</p>
                        @else
                            <h4>{{ $signature->user->name }}</h4>
                        @endif
                        <img src="{{ $signature->image }}" alt="Signature">
                    </td>
                @else
                    @foreach ($document->signature->reverse() as $signature)
                        <td>
                            @if ($signature->notes)
                                <p>{{ $signature->notes }}</p>
                            @else
                                <h4>{{ $signature->user->name }}</h4>
                            @endif
                            <img src="{{ $signature->image }}" alt="Signature">
                        </td>
                    @endforeach
                @endif
            </tr>
        </table>
    @endif

</body>

</html>
