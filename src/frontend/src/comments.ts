import { Comment } from "./interfaces/comment";

async function getComments(): Promise<Array<Comment>>
{
    const response: Response = await fetch('/api/comments');
    return await response.json();
}

function getCommentsHtml(comments: Array<Comment>): string
{
    let commentsHtml: string = ``;
    comments.forEach((item: Comment) => {
        commentsHtml += `
            <div class="comment-item">
                <div class="comment-user_block">
                    <div class="comment-user_name"> ${item.user_name} </div>
                    <div class="comment-user_email"> ${item.user_email} </div>
                </div>
                <div class="comment-content_block">
                    <div class="comment-header"> ${item.header} </div>
                    <div class="comment-content"> ${item.content} </div>
                </div>
            </div>
        `
    })
    return commentsHtml
}

export async function fillComments(): Promise<void>
{
    const comments: Array<Comment> = await getComments();
    document.querySelector<HTMLDivElement>('#comments-container')!.innerHTML = getCommentsHtml(comments)
}

export const comments: string = `
    <div id="comments-container">
    </div>
`

