<?php
global $faq;
$GLOBALS['PAGE_TITLE'] = 'Gérer la FAQ';
$GLOBALS['NO_AJAX'] = true;
addCSS('dashboard.css');
require_view('view/header.php');
?>

<h1><?= $GLOBALS['PAGE_TITLE'] ?></h1>

<main>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Question</th>
                <th>Réponse</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($faq as $elem) :
                $i++;
            ?>
                <tr>
                    <td><?= $elem['faq_id'] ?></td>
                    <td>
                        <textarea name="question" rows="8"><?= $elem['question'] ?></textarea>
                    </td>
                    <td>
                        <textarea name="answer" rows="8"><?= $elem['answer'] ?></textarea>
                    </td>
                    <td>
                        <form>
                            <input type="hidden" name="faq_id" value="<?= $elem['faq_id'] ?>">
                            <input type="submit" value="Modifier" onclick="update_faq(event)" />
                        </form>
                    </td>
                    <td>
                        <form>
                            <input type="hidden" name="faq_id" value="<?= $elem['faq_id'] ?>">
                            <input type="submit" value="Supprimer" onclick="delete_faq(event)" />
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>

            <tr>
                <td>Ajouter une nouvelle question</td>
                <td>
                    <textarea name="question" rows="8">La question</textarea>
                </td>
                <td>
                    <textarea name="answer" rows="8">Votre réponse</textarea>
                </td>
                <td>-</td>
                <td>
                    <form>
                        <input type="submit" value="Ajouter" onclick="add_faq(event)" />
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</main>

<script>
    function add_faq(event) {
        event.preventDefault();

        let question = $(event.target).closest('tr').find('textarea[name="question"]').val();
        let answer = $(event.target).closest('tr').find('textarea[name="answer"]').val();

        $.post(DOMAIN_NAME + '/faq/add', {
            question: question,
            answer: answer
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }

    function update_faq(event) {
        event.preventDefault();

        let faq_id = $(event.target).closest('tr').find('input[name="faq_id"]').val();
        let question = $(event.target).closest('tr').find('textarea[name="question"]').val();
        let answer = $(event.target).closest('tr').find('textarea[name="answer"]').val();

        $.post(DOMAIN_NAME + '/faq/update', {
            faq_id: faq_id,
            question: question,
            answer: answer
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }

    function delete_faq(event) {
        event.preventDefault();

        let faq_id = $(event.target).closest('tr').find('input[name="faq_id"]').val();

        $.post(DOMAIN_NAME + '/faq/delete', {
            faq_id: faq_id
        }, function(data) {
            console.log(data);
            location.reload();
        });
    }
</script>

<?php
require_view('view/footer.php');
?>