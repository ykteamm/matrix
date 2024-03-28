<?php
use Carbon\Carbon;
?>

@extends('admin.layouts.report')
@section('admin_content')
<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <div class="export__file-image">
            <a href="{{route('jamoalar')}}">
                <label for="export__file-image" class="export__file-btn-image" title="Export File"></label>
            </a>
            </div>
            <h1>{{$teacher->first_name}} {{$teacher->last_name}} jamoasi</h1>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="{{asset('assets/report/images/search.png')}}" alt="">
            </div>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF">PDF <img src="{{asset('assets/report/images/pdf.png')}}" alt=""></label>
                    <label for="export-file" id="toJSON">JSON <img src="{{asset('assets/report/images/json.png')}}" alt=""></label>
                    <label for="export-file" id="toCSV">CSV <img src="{{asset('assets/report/images/csv.png')}}" alt=""></label>
                    <label for="export-file" id="toEXCEL">EXCEL <img src="{{asset('assets/report/images/excel.png')}}" alt=""></label>
                </div>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                <tr>
                    <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Ism,Familiya <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Manzil <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Haftalik sotuv <span class="icon-arrow">&UpArrow;</span> <br><br> {{$monday}} - {{$sunday}}</th>
                    <th> Oylik sotuv <span class="icon-arrow">&UpArrow;</span> <br><br> {{$month_name}} </th>
                    <th> Jamoaviy oylik savdo<span class="icon-arrow">&UpArrow;</span> <br><br> Jamoaviy haftalik savdo</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $team_sum_month = 0;
                    $team_sum_week = 0;
                    $id = 1;
                @endphp
                @foreach($users as $user)
                    @php
                        $team_sum_month += $user->month_total_savdo;
                        $team_sum_week += $user->week_total_savdo;
                        $team_sum_format_month = number_format($team_sum_month, 0, '.', ' ');
                        $team_sum_format_week = number_format($team_sum_week, 0, '.', ' ');
                    @endphp
                @endforeach
                @foreach($users as $index => $user)
                    @if($user->id == $teacher->id)
                        @php
                         $weeksum = number_format($user->week_total_savdo, 0, '.', ' ');
                         $monthsum = number_format($user->month_total_savdo, 0, '.', ' ');
                        @endphp
                    <tr class="ustoz" style="background: green;color: white">
                        <td> {{$id++}} </td>
                        <td> <img src="{{$user->image_url}}" alt="">{{$user->first_name}} {{$user->last_name}}</td>
                        <td> {{$user->region_name}}, {{$user->district_name}} </td>
                        <td> {{$weeksum}} </td>
                        <td> {{$monthsum}} </td>
                        <td style="background: red">
                            <p class="status delivered">
                                Oylik <br>
                                {{$team_sum_format_month}}
                            </p>
                            <br>
                            <p class="status delivered">
                                Haftalik <br>
                                {{$team_sum_format_week}}
                            </p>
                        </td>
                    </tr>
                    @else
                        @php
                            $weeksum = number_format($user->week_total_savdo, 0, '.', ' ');
                            $monthsum = number_format($user->month_total_savdo, 0, '.', ' ');
                        @endphp
                        <tr>
                            <td> {{$id++}} </td>
                            <td> <img src="{{$user->image_url}}" alt="">{{$user->first_name}} {{$user->last_name}}</td>
                            <td> {{$user->region_name}}, {{$user->district_name}} </td>
                            <td> {{$weeksum}} </td>
                            <td> {{$monthsum}} </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </section>
    </main>

    <script type="text/javascript">
        const search = document.querySelector('.input-group input'),
            table_rows = document.querySelectorAll('tbody tr'),
            table_headings = document.querySelectorAll('thead th');

        // 1. Searching for specific data of HTML table
        search.addEventListener('input', searchTable);

        function searchTable() {
            table_rows.forEach((row, i) => {
                let table_data = row.textContent.toLowerCase(),
                    search_data = search.value.toLowerCase();

                row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
                row.style.setProperty('--delay', i / 25 + 's');
            })

            document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
                visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
            });
        }

        // 2. Sorting | Ordering data of HTML table

        table_headings.forEach((head, i) => {
            let sort_asc = true;
            head.onclick = () => {
                table_headings.forEach(head => head.classList.remove('active'));
                head.classList.add('active');

                document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
                table_rows.forEach(row => {
                    row.querySelectorAll('td')[i].classList.add('active');
                })

                head.classList.toggle('asc', sort_asc);
                sort_asc = head.classList.contains('asc') ? false : true;

                sortTable(i, sort_asc);
            }
        })


        function sortTable(column, sort_asc) {
            [...table_rows].sort((a, b) => {
                let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
                    second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

                return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
            })
                .map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
        }

        // 3. Converting HTML table to PDF

        const pdf_btn = document.querySelector('#toPDF');
        const customers_table = document.querySelector('#customers_table');


        const toPDF = function (customers_table) {
            const html_code = `
    <!DOCTYPE html>
    <link rel="stylesheet" type="text/css" href="style.css">
    <main class="table" id="customers_table">${customers_table.innerHTML}</main>`;

            const new_window = window.open();
            new_window.document.write(html_code);

            setTimeout(() => {
                new_window.print();
                new_window.close();
            }, 400);
        }

        pdf_btn.onclick = () => {
            toPDF(customers_table);
        }

        // 4. Converting HTML table to JSON

        const json_btn = document.querySelector('#toJSON');

        const toJSON = function (table) {
            let table_data = [],
                t_head = [],

                t_headings = table.querySelectorAll('th'),
                t_rows = table.querySelectorAll('tbody tr');

            for (let t_heading of t_headings) {
                let actual_head = t_heading.textContent.trim().split(' ');

                t_head.push(actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase());
            }

            t_rows.forEach(row => {
                const row_object = {},
                    t_cells = row.querySelectorAll('td');

                t_cells.forEach((t_cell, cell_index) => {
                    const img = t_cell.querySelector('img');
                    if (img) {
                        row_object['customer image'] = decodeURIComponent(img.src);
                    }
                    row_object[t_head[cell_index]] = t_cell.textContent.trim();
                })
                table_data.push(row_object);
            })

            return JSON.stringify(table_data, null, 4);
        }

        json_btn.onclick = () => {
            const json = toJSON(customers_table);
            downloadFile(json, 'json')
        }

        // 5. Converting HTML table to CSV File

        const csv_btn = document.querySelector('#toCSV');

        const toCSV = function (table) {
            // Code For SIMPLE TABLE
            // const t_rows = table.querySelectorAll('tr');
            // return [...t_rows].map(row => {
            //     const cells = row.querySelectorAll('th, td');
            //     return [...cells].map(cell => cell.textContent.trim()).join(',');
            // }).join('\n');

            const t_heads = table.querySelectorAll('th'),
                tbody_rows = table.querySelectorAll('tbody tr');

            const headings = [...t_heads].map(head => {
                let actual_head = head.textContent.trim().split(' ');
                return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
            }).join(',') + ',' + 'image name';

            const table_data = [...tbody_rows].map(row => {
                const cells = row.querySelectorAll('td'),
                    img = decodeURIComponent(row.querySelector('img').src),
                    data_without_img = [...cells].map(cell => cell.textContent.replace(/,/g, ".").trim()).join(',');

                return data_without_img + ',' + img;
            }).join('\n');

            return headings + '\n' + table_data;
        }

        csv_btn.onclick = () => {
            const csv = toCSV(customers_table);
            downloadFile(csv, 'csv', 'customer orders');
        }

        // 6. Converting HTML table to EXCEL File

        const excel_btn = document.querySelector('#toEXCEL');

        const toExcel = function (table) {
            // Code For SIMPLE TABLE
            // const t_rows = table.querySelectorAll('tr');
            // return [...t_rows].map(row => {
            //     const cells = row.querySelectorAll('th, td');
            //     return [...cells].map(cell => cell.textContent.trim()).join('\t');
            // }).join('\n');

            const t_heads = table.querySelectorAll('th'),
                tbody_rows = table.querySelectorAll('tbody tr');

            const headings = [...t_heads].map(head => {
                let actual_head = head.textContent.trim().split(' ');
                return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
            }).join('\t') + '\t' + 'image name';

            const table_data = [...tbody_rows].map(row => {
                const cells = row.querySelectorAll('td'),
                    img = decodeURIComponent(row.querySelector('img').src),
                    data_without_img = [...cells].map(cell => cell.textContent.trim()).join('\t');

                return data_without_img + '\t' + img;
            }).join('\n');

            return headings + '\n' + table_data;
        }

        excel_btn.onclick = () => {
            const excel = toExcel(customers_table);
            downloadFile(excel, 'excel','hisobot.');
        }

        const downloadFile = function (data, fileType, fileName = '') {
            const a = document.createElement('a');
            a.download = fileName;
            const mime_types = {
                'json': 'application/json',
                'csv': 'text/csv',
                'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            }
            a.href = `
        data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
    `;
            document.body.appendChild(a);
            a.click();
            a.remove();
        }


    </script>
</body>
@endsection
