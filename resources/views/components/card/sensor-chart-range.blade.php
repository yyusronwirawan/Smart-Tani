<form class="my-3 col-12 form-group row no-gutters form-date-range-container">
    <div data-url="{{ $chartRangeUrl }}" class="form-date-range col-12">
        <div class="form btn-group-sm btn-group-toggle col-12 row no-gutters justify-content-center"
            data-toggle="buttons">
            <label class="btn btn-outline-primary mx-1 rounded-pill active">
                <input type="radio" name="select-date-range" value="day" class="select-date-range" autocomplete="off"
                    checked="checked">24 Jam
            </label>
            <label class="btn btn-outline-primary mx-1 rounded-pill">
                <input type="radio" name="select-date-range" value="week" class="select-date-range" autocomplete="off">7
                Hari
            </label>
            <label class="btn btn-outline-primary mx-1 rounded-pill">
                <input type="radio" name="select-date-range" value="month" class="select-date-range "
                    autocomplete="off ">30 Hari
            </label>
        </div>
    </div>
</form>
<div class="chart-refresh col-12 justify-content-end no-gutters row">
    <button class="btn btn-info btn-sm chart-refresh" role="button"><i class="fas fa-redo-alt"></i>
        Perbarui</button>
</div>
