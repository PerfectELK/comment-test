import './css/normalize.css'
import './css/style.css'
import { comments, fillComments } from "./comments";
import { listenForm } from "./comment-form";

document.querySelector<HTMLDivElement>('#app')!.innerHTML = `
  <div>
    <header>
        <div class="site-logo">
            Logo
        </div>
        <nav>
            <div class="menu-item">Главная</div>
            <div class="menu-item">Не главная</div>
            <div class="menu-item">2 не главная</div>
        </nav>
        <div></div>
    </header>
    <main>
        <div class="article-header-container">
            <h1>Комментная лиловая, спелая, садовая</h1>
        </div>
        <div class="article-container">
            <div class="article-header">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur, quae.
            </div>
            <article>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                <p>Beatae blanditiis culpa cumque debitis ea, esse explicabo, fugiat id illo inventore laborum necessitatibus officiis optio praesentium, quasi quis quos repellendus vitae.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A asperiores atque beatae cum deleniti dolorem dolores doloribus enim eum fuga impedit inventore ipsum iste laboriosam laborum nemo nesciunt nisi omnis perspiciatis placeat quam quo repellendus sequi ut vero, voluptate, voluptates.</p>
            </article>
        </div>
        <div class="comment-block-container">
            <div class="comment-block-header">
                Комментарии к статье
            </div>
            ${comments}
        </div>
        <div class="comment-form-container">
            <form id="comment-form">
                <div>
                    <label> 
                        <div>Имя пользователя:</div>
                        <div class="error"></div>
                        <input type="text" name="user_name">
                    </label>
                </div>
                <div>
                    <label>
                        <div>Email:</div>
                        <div class="error"></div>
                        <input type="email" name="user_email">
                    </label>
                </div>
                <div>
                    <label>
                        <div>Заголовок:</div>
                        <div class="error"></div>
                        <input type="text" name="header">
                    </label>
                </div>
                <div>
                    <label>
                        <div>Текст комментария:</div>
                        <div class="error"></div>
                        <textarea name="content" cols="30" rows="10"></textarea>
                    </label>
                </div>
                
                <div>
                    <button type="submit">
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <div>Подвал комментной</div>
    </footer>
  </div>
`

fillComments();
listenForm();
