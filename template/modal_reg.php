<!-- Modal -->

<div class="modal fade" id="modal_reg" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Регистрация на игру</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row w-100 justify-content-center">
                    <img src="" alt="лого" id="form_reg_game_logo" class="img-fluid text-center" >
                </div>
                <form class="needs-validation" action="#" method="post" id="form-register" novalidate>
                    <div class="form-group row">
                        <label for="form_reg_select" class="col-6 col-form-label">Выберите игру:</label>
                        <div class="col-6 mb-3">
                            <select name="form_reg_gameid" class="form-control form-control-sm" id="form_reg_select">                               
                            </select>
                        </div>
                    </div> 
                    <div class="col mb-3">
                        <div class="input-group input-group-team">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                            </div>
                            <input type="text" class="form-control check name_mask" name="reg_input_team" placeholder="Название Команды"  value="" minlength="3" required>
                            <div class="invalid-feedback">
                                неверно заполнено поле
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="input-group">
                            <label for="reg_input_gamers_qnt" id="reg_input_gamers_qnt_text"></label>
                            <input type="range" class="custom-range check" name="reg_input_gamers_qnt" id="reg_input_gamers_qnt" min="2" max="10"  step="1" value="2" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="reg_input_check_gamers">
                            <label class="form-check-label" for="reg_input_check_gamers">
                                Я один. Найдите мне команду.
                            </label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control name_mask check" name="reg_input_name"  placeholder="Капитан команды"  value="" minlength="3" required>
                                <div class="invalid-feedback">
                                    неверно заполнено поле
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control tel_mask check" name="reg_input_tel" placeholder="Телефон"  minlength="3" required>
                                <div class="invalid-feedback">
                                    неверный телефон
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                </div>
                                <input type="text" class="form-control email_mask check" name="reg_input_email" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    неверный email
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input check" type="checkbox" value="" id="reg_input_check" required>
                            <label class="form-check-label" for="reg_input_check">
                                Я прочитал и согласен с <a href="/template/oferta_page.php" target="_blank">пользовательским соглашением</a>
                            </label>
                            <div class="invalid-feedback">
                                необходимо принять условия пользовательского солашения
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="form_reg">
                    <button class="btn btn-primary" type="submit">Отправить</button>
                </form>
                <div class="result_ d-none"></div>
            </div>
        </div>
    </div>
</div>