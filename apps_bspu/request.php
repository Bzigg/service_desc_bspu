<?php
    include_once('functions/common_functions.php');
    include_once('functions/request_function.php');

    head('Добавить заявку');
?>

<div class="container">
    <div class="main_inner">
        <div class="reg_window">
            <form class="form_login" action="request.php" method="post">
                <p>Новая заявка</p>
                    <input type="text" name="request_name" placeholder="ФИО" required>
                    <input type="tel" name="request_tel" placeholder="Телефон" required>
                    <input type="text" name="request_building" placeholder="Корпус" required>
                    <input type="text" name="request_cabinet" placeholder="Кабинет" required>

                        <select name="request_problem" id="problem" required>
                            <option value="1" selected disabled>Выберите проблему</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>                    
                        </select>

                    <textarea required name="request_comment" id="comment" cols="50" rows="5" placeholder="Опишите проблему"></textarea>
                    <input type="submit" name="request_button" value="Отправить" id="submit">
            </form>
        </div>
    </div>
</div>



<?php
    footer();
?>