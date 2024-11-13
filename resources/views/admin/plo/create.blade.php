<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo PLO (Program Learning Outcomes)') }}
        </h2>
    </x-slot>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-labels {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .form-label {
            flex: 1;
            text-align: center;
            font-weight: bold;
        }

        .plo-outcome {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .plo-outcome .form-control {
            margin: 0 5px;
            flex: 1 0 30%;
            min-width: 100px;
        }

        .remove-outcome {
            margin-left: 10px;
        }
    </style>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('plos.index') }}" class="btn btn-secondary mb-3">Quay lại</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-14">
                        <h1>Tạo PLO (Program Learning Outcomes)</h1>
                        <form action="{{ route('plos.store') }}" method="POST">
                            @csrf

                            <div class="plo-outcome-container">

                                <div class="form-labels">
                                    <div class="form-label">Chọn Chuyên Ngành</div>
                                    <div class="form-label">Tên PLO</div>
                                    <div class="form-label">Mô tả</div>
                                </div>

                                <div id="plo-outcomes-container">
                                    <div class="plo-outcome">
                                        <!-- Chọn chuyên ngành -->
                                        <div class="form-group">
                                            <select name="major_id[0][]" class="form-control select2" multiple required>
                                                <option value="">Chọn chuyên ngành</option>
                                                @foreach ($allMajors as $major)
                                                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('major_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tên PLO -->
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="name[]"
                                                value="{{ old('name') }}" placeholder="Nhập tên PLO" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Mô tả -->
                                        <div class="mb-3">
                                            <textarea class="form-control" name="description[]" placeholder="Nhập mô tả PLO" rows="2">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="remove-outcome">
                                            <button type="button" class="btn btn-danger remove-btn">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Lưu PLO</button>
                            <button type="button" id="add-plo" class="btn btn-primary mt-3">Thêm PLO</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    $(document).ready(function() {
        // Khởi tạo select2 cho các phần tử hiện có
        $('.select2').select2({
            placeholder: "Chọn chuyên ngành",
            allowClear: true,
            multiple: true
        });

        $('#add-plo').click(function() {
            const $container = $('#plo-outcomes-container');
            const $newOutcome = $('.plo-outcome').first().clone(); // Sao chép nhóm trường đầu tiên

            // Xóa giá trị của các input fields trong nhóm mới (trừ các trường hidden và mã chuyên ngành)
            $newOutcome.find('input:not([type=hidden]), textarea').val('');
            $newOutcome.find('.form-group').each(function() {
                // Dùng hidden input cho major_id, không thay đổi
                $(this).find('select').attr('name', 'major_id[' + ($container.children()
                    .length) + '][]');
            });

            // Lấy giá trị của mã chuyên ngành từ nhóm trường trên và gán vào nhóm trường mới
            const previousMajors = $container.children().last().find('select[name^="major_id"]')
                .val(); // Lấy giá trị của chuyên ngành ở nhóm trên
            $newOutcome.find('select[name^="major_id"]').val(
                previousMajors); // Gán lại giá trị cho select trong nhóm mới

            // Thêm nhóm trường mới vào container
            $container.append($newOutcome);

            // Thêm nút "Remove" cho nhóm trường mới
            $newOutcome.find('.remove-outcome').html(
                '<button type="button" class="btn btn-danger remove-btn">Xóa</button>');


            // Thêm sự kiện "Remove" cho nút xóa mới
            $newOutcome.find('.remove-btn').click(function() {
                $(this).closest('.plo-outcome').remove(); // Xóa nhóm trường khi nhấn nút Remove
            });
        });
    });
</script>
