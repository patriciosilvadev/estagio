<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/novounidade">
            Nova Unidades
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter Unidades</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="4">
                            Lista de Unidades
                <form method="get" action="<?php echo base_url() ?>internacao/internacao/pesquisarunidade">
                    <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                    <button type="submit" name="enviar">Pesquisar</button>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Codigo</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Localiza&ccedil;&atilde;o</th>
                    <th class="tabela_header" width="30px;"><center></center></th>
                <th class="tabela_header" width="30px;"><center></center></th>

                </tr>
                </thead>
                <?php
                 $perfil_id = $this->session->userdata('perfil_id'); 
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->unidade_m->listaunidade($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->unidade_m->listaunidade($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->internacao_unidade_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->localizacao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a href="<?= base_url() ?>internacao/internacao/carregarunidade/<?= $item->internacao_unidade_id ?>"><center>
                                            <img border="0" title="Alterar registro" alt="Detalhes"
                                                 src="<?= base_url() ?>img/form/page_white_edit.png" />
                                        </center></a>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <?php if($this->session->userdata('perfil_id') != 25 && $perfil_id != 18 && $perfil_id != 20){?>
                                    <a onclick="javascript: return confirm('Deseja realmente excluir a Unidade?');"
                                       href="<?=base_url()?>internacao/internacao/excluirunidade/<?= $item->internacao_unidade_id ?>">
                                        <center><img border="0" title="Excluir" alt="Excluir"
                                                    src="<?=  base_url()?>img/form/page_white_delete.png" /></center>
                                    </a>
                                     <?php }?>
                                </td>
                               
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="7">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
   
    $(function() {
        $( "#accordion" ).accordion();
    });

</script>