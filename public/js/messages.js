$(document).ready(function() {
    // --- Filter Checkbox List by Search ---
    $('#opd-phone-search').on('input', function() {
        let keyword = $(this).val().toLowerCase();
        $('#opd-phone-checkbox-list .checkbox-item').each(function() {
            let text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(keyword) !== -1);
        });
    });

    // --- Pilih Semua OPD/ASN ---
    $('#select-all-opd').on('change', function() {
        $('#opd-phone-checkbox-list input[name="opd_phone[]"]').prop('checked', $(this).is(':checked')).trigger('change');
    });
    $('#select-all-asn').on('change', function() {
        $('#opd-phone-checkbox-list input[name="asn_phone[]"]').prop('checked', $(this).is(':checked')).trigger('change');
    });

    // --- Tampilkan Input Custom Nomor ---
    $('#custom-phone-toggle').on('change', function() {
        if ($(this).is(':checked')) {
            $('#custom-phone-group').removeClass('hidden');
        } else {
            $('#custom-phone-group').addClass('hidden');
            $('#custom-phone').val('');
        }
    });

    // --- Tampilkan Checkbox List Saat Search Di-Fokus ---
    $('#opd-phone-search').on('focus click', function() {
        $('#opd-phone-checkbox-list').removeClass('hidden');
    });

    // --- Sembunyikan Checkbox List Jika Klik di Luar ---
    $(document).on('mousedown', function(e) {
        if (
            !$(e.target).closest('#opd-phone-search').length &&
            !$(e.target).closest('#opd-phone-checkbox-list').length
        ) {
            $('#opd-phone-checkbox-list').addClass('hidden');
        }
    });

    // --- Validasi dan Gabungkan Nomor Sebelum Submit ---
    $('form').on('submit', function(e) {
        let selectedPhones = [];
        $('#opd-phone-checkbox-list input[name="opd_phone[]"]:checked').each(function() {
            if ($(this).attr('id') !== 'select-all-opd') {
                selectedPhones.push($(this).val());
            }
        });
        $('#opd-phone-checkbox-list input[name="asn_phone[]"]:checked').each(function() {
            if ($(this).attr('id') !== 'select-all-asn') {
                selectedPhones.push($(this).val());
            }
        });

        let customPhones = [];
        if ($('#custom-phone-toggle').is(':checked')) {
            let customVal = $('#custom-phone').val().trim();
            if (!customVal) {
                alert('Masukkan nomor custom jika memilih Nomor Custom!');
                $('#custom-phone').focus();
                e.preventDefault();
                return false;
            }
            customPhones = customVal
                .split(',')
                .map(function(n) {
                    n = n.trim();
                    if (n) {
                        if (!n.startsWith('62')) n = '62' + n.replace(/^0+/, '');
                        return '+' + n;
                    }
                    return null;
                })
                .filter(Boolean);
        }

        let allPhones = selectedPhones.concat(customPhones);
        $('#phone').val(allPhones.join(','));

        if (allPhones.length === 0) {
            alert('Nomor WhatsApp wajib diisi!');
            e.preventDefault();
            return false;
        }

        // Validasi pesan wajib diisi
        if (typeof simplemde !== 'undefined' && simplemde.value().trim() === '') {
            alert('Pesan wajib diisi!');
            if (simplemde.codemirror) {
                simplemde.codemirror.focus();
            }
            e.preventDefault();
            return false;
        }

        // Validasi schedule
        if ($('#schedule-select').val() === 'schedule') {
            const tanggal = $('#schedule-date').val();
            const jam = $('#schedule-time').val();
            if (!tanggal || !jam) {
                alert('Silakan isi tanggal dan jam kirim untuk pengiriman terjadwal.');
                e.preventDefault();
                return false;
            }
        }
    });

    // --- Ringkasan Pilihan Nomor ---
    function updateSelectedOpdSummary() {
        let $summary = $('#selected-opd-summary');
        let checked = $('#opd-phone-checkbox-list input[type="checkbox"]:checked');
        let names = [];
        checked.each(function() {
            if (
                $(this).attr('id') === 'select-all-opd' ||
                $(this).attr('id') === 'select-all-asn'
            ) return;

            let label = $(this).closest('.checkbox-item').find('span').text();
            if ($(this).attr('id') === 'custom-phone-toggle') {
                label = 'Nomor Custom';
            }
            names.push(label);
        });

        if (names.length === 0) {
            $summary.html('');
            return;
        }

        let displayNames = names.slice(0, 1).join(', ');
        if (names.length > 1) displayNames += ', ...';
        $summary.html(
            `<span class="summary-names">${displayNames}</span>
            <span class="summary-count">(${names.length})</span>`
        );
    }
    $('#opd-phone-checkbox-list input[type="checkbox"]').on('change', updateSelectedOpdSummary);
    updateSelectedOpdSummary();

    // --- Tampilkan/Hide Schedule Options ---
    function toggleScheduleOptions() {
        if ($('#schedule-select').val() === 'schedule') {
            $('.schedule-options').removeClass('hidden');
        } else {
            $('.schedule-options').addClass('hidden');
            $('#schedule-date').val('');
            $('#schedule-time').val('');
        }
    }
    toggleScheduleOptions();
    $('#schedule-select').on('change', toggleScheduleOptions);

    // --- Validasi Tanggal dan Jam Kirim ---
    $('#schedule-date, #schedule-time').on('change', function() {
        let selectedDate = $('#schedule-date').val();
        let selectedTime = $('#schedule-time').val();
        if (!selectedDate || !selectedTime) return;

        let now = new Date();
        let selected = new Date(selectedDate + 'T' + selectedTime);

        let today = now.toISOString().slice(0,10);
        let nowTime = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

        if (selectedDate < today || (selectedDate === today && selectedTime < nowTime)) {
            alert('Tanggal dan jam kirim tidak boleh lewat dari waktu sekarang!');
            $('#schedule-time').val('');
        }
    });

    // --- Inisialisasi SimpleMDE dan Preview WhatsApp ---
    var simplemde = null;
    if (document.getElementById('message-text')) {
        simplemde = new SimpleMDE({
            element: document.getElementById("message-text"),
            spellChecker: false,
            toolbar: [
                "bold", "italic", "strikethrough", "|",
                "unordered-list", "ordered-list", "|",
                "quote", "|",
                "preview"
            ],
            status: false,
            placeholder: "Tulis pesan WhatsApp di sini..."
        });

        function updatePreview() {
            var md = simplemde.value();
            var wa = markdownToWhatsappJS(md);
            $('#wa-preview').text(wa);
        }
        simplemde.codemirror.on('change', updatePreview);
        updatePreview();
    }

    // --- Fungsi Konversi Markdown ke Format WhatsApp ---
    function markdownToWhatsappJS(text) {
        text = text.replace(/(\*\*\*|___)([\s\S]+?)\1/g, '<<BI>>$2<</BI>>');
        text = text.replace(/(\*\*)(?!\*)([\s\S]+?)\1/g, '<<B>>$2<</B>>');
        text = text.replace(/(__)(?!_)([\s\S]+?)\1/g, '<<B>>$2<</B>>');
        text = text.replace(/(^|[^\*])\*([^\*]+?)\*(?!\*)/g, '$1_$2_');
        text = text.replace(/(^|[^_])_([^_]+?)_(?!_)/g, '$1_$2_');
        text = text.replace(/<<BI>>([\s\S]+?)<<\/BI>>/g, '*_$1_*');
        text = text.replace(/<<B>>([\s\S]+?)<<\/B>>/g, '*$1*');
        text = text.replace(/~~([\s\S]+?)~~/g, '~$1~');
        text = text.replace(/^(\s*)[-*]\s+/gm, "$1• ");
        text = text.replace(/^> ?(.*)$/gm, "```$1```");
        text = text.replace(/^#{1,6}\s*/gm, '');
        text = text.replace(/```([\s\S]*?)```/g, '$1');
        return text;
    }
});