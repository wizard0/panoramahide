@extends('layouts.app')

@section('content')
<div class="promo-head">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
		        <h1>Получите доступ к эксклюзивным материалам</h1>
        		<div style="width: 80%;">
        			<p>Заполните все поля регистрационной формы. В поле "промокод" используйте код из письма.</p>
        			<p>После отправки формы на Ваш телефон придёт смс-уведомление с кодом, который нужно ввести для подтверждения подлинности вашего номера телефона.</p>
        			<p>Нужно указывать номер мобильного телефона.</p>
        		</div>
        	</div>

<div class="col-lg-6 col-lg-offset-2">
     	 <div class="form-container">
              	  <form id="user_form">
  				 <div class="form-wrapper">
    				 <div class="form-row">
      				 <div class="form-label">Фамилия:</div>
      				 <div class="form-holder"><input type="text" class="form-field" name="surname" placeholder="" required="" value=""></div>
    				 </div>
				  <div class="form-row">
  				  <div class="form-label">Имя:</div>
  				  <div class="form-holder"><input type="text" class="form-field" name="name" placeholder="" required="" value=""></div>
          </div>

          <div class="form-row">
  				 <div class="form-label">Отчество:</div>
  				 <div class="form-holder"><input type="text" class="form-field" name="patronymic" placeholder="" required="" value=""></div>
          </div>

          <div class="form-row">
  				 <div class="form-label">Email:</div>
  				 <div class="form-holder"><input type="email" class="form-field" name="email" placeholder="" required="" value=""></div>
				  </div>

                 <div class="form-row">
				 <div class="form-label">Моб. телефон:</div>
				 <div class="form-holder"><input type="phone" class="form-field" name="phone" placeholder="+7(xxx)-xxx-xx-xx" required="" value=""></div>
				 </div>

				<div class="form-row" id="publisher" style="display: none;">
          <div class="form-label">Издательство:</div>
				    <div class="form-holder">
					    <select name="publisher" class="form-control" placeholder="Выберите издательство из списка">
               <option value="">-</option>
                               <option value="789">Промиздат</option>
                               <option value="790">Сельхозиздат</option>
                               <option value="781">Афина (Академия ФИНАнсов)</option>
                               <option value="785">Медиздат</option>
                               <option value="786">Наука и культура</option>
                               <option value="791">Стройиздат</option>
                               <option value="784">Индустрия гостеприимства и торговли (HORECA)</option>
                               <option value="792">Транспорт и связь</option>
                               <option value="783">Внешэкономиздат</option>
                               <option value="788">Политэкономиздат</option>
                               <option value="793">Ты и твой дом</option>
                               <option value="787">Панорама - спорт</option>
                               <option value="58153">18+</option>
                             </select>
				    </div>
				</div>
        <div class="form-row" id="journal" style="display: none;">
          <div class="form-label">Журнал:</div>
            <div class="form-holder">
              <select name="journal" class="form-control" placeholder="Выберите журнал из списка">
              </select>
            </div>
        </div>
        <div class="form-row" id="number" style="display: none;">
          <div class="form-label">Выпуск:</div>
            <div class="form-holder">
              <select name="number" class="form-control" placeholder="Выберите выпуск из списка">
              </select>
            </div>
        </div>

        <div class="form-row">
				 <div class="form-label">Промокод:</div>
				 <div class="form-holder"><input type="text" class="form-field promocode" name="promocode" required=""></div>
				 </div>


          <div class="form-row">
            <div class="form-label"></div>
         <div class="form-holder"><input type="checkbox" value="1" name="UF_PROC_PER_DATA" checked="checked" required=""> Я согласен на обработку <a href="http://panor.ru/coglasie-na-obrabotku-personalnykh-dannykh/" target="_blank">своих персональных данных</a></div>

         </div>



        </div>

            <div class="button-holder">
				    <!-- <a class="btn btn-primary text-uppercase" data-toggle="modal" data-target="#send-code" value="Получить доступ">Получить доступ</a> -->
            <button class="btn btn-primary text-uppercase" id="btn_access" value="Получить доступ">Получить доступ</button>
                  </div>

                  <div class="text-center">
                      <span>Все поля обязательны для заполнения</span>
                  </div>
				          </form>
                                 </div>

           </div>

      	</div>
	</div>
</div>
@endsection
