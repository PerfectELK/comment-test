import { Comment } from "./interfaces/comment";
import {fillComments} from "./comments";

export function listenForm(): void
{
    const el: HTMLFormElement | null = document.querySelector<HTMLFormElement>('#comment-form');
    if (el === null) {
        return;
    }
    el.onsubmit = async (event) => {
        event.preventDefault();
        const formValues: Comment | null = getValuesFromForm(event);
        if (formValues === null) {
            return;
        }
        const isValid: boolean = validate(formValues);
        if (!isValid) {
            return;
        }
        const response = await sendForm(formValues);

        if (response.errors) {
            for (const [key, value] of Object.entries(response.errors)) {
                showInputError(key, value as string);
            }
            return;
        }
        await fillComments();
    };
}


function getValuesFromForm(event: SubmitEvent): Comment | null
{
    const target = event.target;
    if (target === null) {
        return null;
    }
    // @ts-ignore
    const elements = target.elements;
    const result = {} as Comment;
    for (let i = 0; i < elements.length; i++) {
        const element: HTMLInputElement | HTMLTextAreaElement = elements[i];
        if (element.tagName === 'BUTTON') {
            continue;
        }
        result[element.name as keyof Comment] = element.value;
    }
    return result;
}

function validate(formValues: Comment): boolean
{
    let isValid: boolean = true;
    for (const [key, value] of Object.entries(formValues)) {
        if (!value.length) {
            isValid = false;
            showInputError(key, 'Неверно заполнено поле');
        }
    }

    return isValid;
}

function showInputError(
    inputName: string,
    error: string
): void
{
    const el: HTMLInputElement | HTMLTextAreaElement | null = document.querySelector(`form input[name=${inputName}], form textarea[name=${inputName}]`);
    if (el === null) {
        return;
    }
    const errorDiv: Element | null = el.previousElementSibling;
    if (errorDiv === null) {
        return;
    }
    errorDiv.innerHTML = error;
    setTimeout(() => {
        errorDiv.innerHTML = ''
    }, 2000)
}

async function sendForm(data: Comment): Promise<any>
{
    const response = await fetch('/api/comment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    });
    return response.json();
}