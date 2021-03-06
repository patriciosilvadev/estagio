<?php

class login_model extends Model {
    /* Método construtor */

    function Login_model($servidor_id = null) {
        parent::Model();
    }

    function listarEmpresa(){
        
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.*, 
                           ep.procedimento_excecao, 
                           ep.calendario_layout, 
                           ep.recomendacao_configuravel, 
                           ep.recomendacao_obrigatorio, 
                           ep.valor_autorizar,
                           ep.gerente_contasapagar,
                           ep.cpf_obrigatorio,
                           ep.orcamento_recepcao,
                           ep.relatorio_ordem,
                           ep.relatorio_producao,
                           ep.relatorios_recepcao,
                           ep.laudo_sigiloso,
                           ep.gerente_relatorio_financeiro,
                           ep.financeiro_cadastro,             
                           ep.caixa_personalizado,       
                           ep.botao_ativar_sala,
                           ep.retirar_preco_procedimento,
                           ep.relatorios_clinica_med,
                           ep.autorizar_sala_espera,
                           ep.manter_indicacao,
                           ep.fila_impressao,
                           ep.medico_solicitante,
                           ep.uso_salas,
                           ep.relatorio_operadora,
                           ep.relatorio_rm,
                           ep.relatorio_demandagrupo,
                           ep.profissional_agendar,
                           ep.relatorio_caixa,
                           ep.enfermagem,
                           ep.integracaosollis,
                           ep.medicinadotrabalho,
                           ep.ocupacao_pai,
                           ep.ocupacao_mae,
                           ep.atendimento_medico,
                           ep.limitar_acesso,
                           ep.manternota,
                           ep.perfil_marketing_p,
                           ep.subgrupo_procedimento');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id');
//        
        $this->db->where('e.empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function autenticar($usuario, $senha, $empresa) {
        $this->db->select(' o.operador_id,
                                o.perfil_id,
                                o.profissional_agendar_o,
                                p.nome as perfil,
                                a.modulo_id,
                                oe.operador_empresa_id,
                                o.medico_agenda'
        );
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id', 'left');
        $this->db->join('tb_operador_empresas oe', 'oe.operador_id = o.operador_id', 'left');
        $this->db->where('o.usuario', $usuario);
        $this->db->where('o.senha', md5($senha));
        $this->db->where('oe.empresa_id', $empresa);
        $this->db->where('oe.ativo = true');
        $this->db->where('o.ativo = true');
        $this->db->where('p.ativo = true');
        $return = $this->db->get()->result();

        $this->db->select('e.*, 
                           ep.procedimento_excecao, 
                           ep.recomendacao_configuravel, 
                           ep.recomendacao_obrigatorio, 
                           ep.valor_autorizar,
                           ep.gerente_contasapagar,
                           ep.cpf_obrigatorio,
                           ep.orcamento_recepcao,
                           ep.relatorio_ordem,
                           ep.relatorio_producao,
                           ep.relatorios_recepcao,          
                           ep.caixa_personalizado,       
                           ep.retirar_preco_procedimento,
                           ep.autorizar_sala_espera,
                           ep.manter_indicacao,
                           ep.fila_impressao,
                           ep.medico_solicitante,
                           ep.uso_salas,
                           ep.relatorio_operadora,
                           ep.relatorio_rm,
                           ep.relatorio_demandagrupo,
                           ep.profissional_agendar,
                           ep.relatorio_caixa,
                           ep.enfermagem,
                           ep.medicinadotrabalho,
                           ep.subgrupo_procedimento');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id');
//        
        $this->db->where('e.empresa_id', $empresa);
        $retorno = $this->db->get()->result();

        if (count($retorno) > 0) {
            $servicosms = $retorno[0]->servicosms;
            $servicoemail = $retorno[0]->servicoemail;
            $empresanome = $retorno[0]->nome;
            $chat = $retorno[0]->chat;
            $farmacia = @$retorno[0]->farmacia;
            $centrocirurgico = $retorno[0]->centrocirurgico;
            $relatoriorm = $retorno[0]->relatoriorm;
            $autorizar_sala_espera = $retorno[0]->autorizar_sala_espera;
            $odontologia = $retorno[0]->odontologia;
            $profissional_agendar = $retorno[0]->profissional_agendar;
            $caixa = @$retorno[0]->caixa;
            $procedimento_multiempresa = $retorno[0]->procedimento_multiempresa;
            $botao_faturar_guia = $retorno[0]->botao_faturar_guia;
            $botao_faturar_proc = $retorno[0]->botao_faturar_procedimento;
            $producao_medica_saida = $retorno[0]->producao_medica_saida;
            $procedimento_excecao = $retorno[0]->procedimento_excecao;
            $recomendacao_configuravel = $retorno[0]->recomendacao_configuravel;
            $recomendacao_obrigatorio = $retorno[0]->recomendacao_obrigatorio;


            $gerente_contasapagar = $retorno[0]->gerente_contasapagar;
            $orcamento_recepcao = $retorno[0]->orcamento_recepcao;
            $relatorio_ordem = $retorno[0]->relatorio_ordem;
            $relatorio_producao = $retorno[0]->relatorio_producao;
            $relatorios_recepcao = $retorno[0]->relatorios_recepcao;
            $logo_clinica = @$retorno[0]->mostrar_logo_clinica;
            $caixa_personalizado = $retorno[0]->caixa_personalizado;
            $subgrupo_procedimento = $retorno[0]->subgrupo_procedimento;
            $retirar_preco_procedimento = $retorno[0]->retirar_preco_procedimento;
            $manter_indicacao = $retorno[0]->manter_indicacao;
            $fila_impressao = $retorno[0]->fila_impressao;
            $endereco_toten = @$retorno[0]->endereco_toten;
            $medico_solicitante = $retorno[0]->medico_solicitante;
            $relatorio_operadora = $retorno[0]->relatorio_operadora;
            $relatorio_rm = $retorno[0]->relatorio_rm;
            $uso_salas = $retorno[0]->uso_salas;
            $relatorio_demandagrupo = $retorno[0]->relatorio_demandagrupo;
            $relatorio_caixa = $retorno[0]->relatorio_caixa;
            $enfermagem = $retorno[0]->enfermagem;
          
        } else {
            $empresanome = "";
        }
        
        if (isset($return) && count($return) > 0) {

            //marcando o usuario como 'online'
            $horario = date("Y-m-d H:i:s");
            $this->db->set('horario_login', $horario);
            $this->db->set('online', 't');
            $this->db->where('operador_id', $return[0]->operador_id);
            $this->db->update('tb_operador');

            $modulo[] = null;
            foreach ($return as $value) {
                if (isset($value->modulo_id)) {
                    $modulo[] = $value->modulo_id;
                }
            }
            $p = array(
                'autenticado' => true,
                'operador_id' => $return[0]->operador_id,
                'login' => $usuario,
                'perfil_id' => $return[0]->perfil_id,
                'perfil' => $return[0]->perfil,
                'modulo' => $modulo,
                'autorizar_sala_espera' => $autorizar_sala_espera,
                'endereco_toten' => $endereco_toten,
                'botao_faturar_guia' => $botao_faturar_guia,
                'botao_faturar_proc' => $botao_faturar_proc,
                'empresa_id' => $empresa,
                'procedimento_multiempresa' => $procedimento_multiempresa,
                'producao_medica_saida' => $producao_medica_saida,
                'procedimento_excecao' => $procedimento_excecao,
                'recomendacao_configuravel' => $recomendacao_configuravel,
                'recomendacao_obrigatorio' => $recomendacao_obrigatorio,
                'logo_clinica' => $logo_clinica,
                'subgrupo_procedimento' => $subgrupo_procedimento,
                'empresa' => $empresanome,
                'medico_agenda' => $return[0]->medico_agenda
            );
            $this->session->set_userdata($p);
            return true;
        } else {
            $this->session->sess_destroy();
            return false;
        }
    }

    function autenticarweb($usuario, $senha, $empresa) {
        $this->db->select(' o.operador_id,
                                o.perfil_id,
                                o.profissional_agendar_o,
                                p.nome as perfil,
                                a.modulo_id,
                                oe.operador_empresa_id'
        );
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id', 'left');
        $this->db->join('tb_operador_empresas oe', 'oe.operador_id = o.operador_id', 'left');
        $this->db->where('o.usuario', $usuario);
        $this->db->where('o.senha', $senha);
        $this->db->where('oe.empresa_id', $empresa);
        $this->db->where('oe.ativo = true');
        $this->db->where('o.ativo = true');
        $this->db->where('p.ativo = true');
        $return = $this->db->get()->result();
        
        return $return;
        
        
    }

    function atualizandoatendidostabelasms($exames, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_agradecimento');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_agradecimento;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($exames as $item) {
            if ($i <= $disponivel) {
                $this->db->set('sms_enviado', 't');
                $this->db->where('agenda_exames_id', $item->agenda_exames_id);
                $this->db->update('tb_agenda_exames');

                $this->db->set('agenda_exames_id', $item->agenda_exames_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', $empresa_id);

                $numero = ($item->celular != '') ? $item->celular : $item->telefone;

                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
                $this->db->set('mensagem', $mensagem);
                $this->db->set('tipo', 'AGRADECIMENTO');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function atualizandoagendadostabelasms($exames, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_confirmacao');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_confirmacao;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($exames as $item) {
            if ($i <= $disponivel) {
//
                $this->db->set('sms_enviado', 't');
                $this->db->where('agenda_exames_id', $item->agenda_exames_id);
                $this->db->update('tb_agenda_exames');

                $numero = ($item->celular != '') ? $item->celular : $item->telefone;
                
                $mensagem = str_replace("_dia_", date("d/m/Y", strtotime($item->data)), $mensagem);
                $mensagem = str_replace("_horainicio_", substr($item->inicio, 0, 5), $mensagem);
                        
                $this->db->set('agenda_exames_id', $item->agenda_exames_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
                $this->db->set('mensagem', $mensagem);
                $this->db->set('tipo', 'CONFIRMACAO');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function autenticarpacienteweb($usuario, $senha) {
        // $horario = date("Y-m-d");
        $this->db->select('p.paciente_id, p.nome, p.cpf, p.cns');
        $this->db->from('tb_paciente p');
        $this->db->where('p.cns', $usuario);
        $this->db->where('p.senha_app', md5($senha));
        $this->db->where('p.ativo', 't');
        $return = $this->db->get()->result();

        if(count($return) == 0 && is_int($usuario)){
            $this->db->select('ae.agenda_exames_id, p.nome, p.cpf, p.cns');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
            $this->db->where('ae.paciente_id', $usuario);
            $this->db->where('p.ativo', 't');
            $this->db->where('ae.agenda_exames_id', $senha);
            $return = $this->db->get()->result();
        }

        // if(count($return) == 0){
        //     $this->db->select('0 as paciente_id, p.nome, p.cpf, p.email as cns', false);
        //     $this->db->from('tb_paciente_precadastro_c p');
        //     $this->db->where('p.email', $usuario);
        //     $this->db->where('p.senha_app', md5($senha));
        //     $this->db->where('p.ativo', 't');
        //     $return = $this->db->get()->result();
        //     // var_dump($return); die;
        // }
       
        return $return;
    }

    function email_verificacao($usuario) {
        // $horario = date("Y-m-d");
        $this->db->select('p.paciente_id, p.nome, p.cpf, p.cns');
        $this->db->from('tb_paciente p');
        $this->db->where('p.cns', $usuario);
        $this->db->where('p.ativo', 't');
        $return = $this->db->get()->result();
        return $return;
    }

    function revisoes() {
        $horario = date("Y-m-d");

        $this->db->select('ae.agenda_exames_id,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           pt.nome,
                           pt.revisao_dias,
                           p.telefone');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('p.ativo', 't');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where("pt.procedimento_tuss_id IN (
                            SELECT procedimento_tuss_id FROM ponto.tb_procedimento_tuss
                            WHERE revisao = 't'
                          )
                          AND (ae.data + pt.revisao_dias) =  '{$horario}'");
        $return = $this->db->get();
        return $return->result();
    }

    function atualizandorevisoestabelasms($revisoes, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_revisao');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_revisao;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($revisoes as $item) {
            if ($i <= $disponivel) {
                $msg = $mensagem . " Procedimento: " . $item->nome;
                $this->db->set('paciente_id', $item->paciente_id);
                $numero = ($item->celular != '') ? $item->celular : $item->telefone;
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('mensagem', $msg);
                $this->db->set('tipo', 'REVISAO');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function listarempresasmsdados() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('ip_servidor_sms, enviar_excedentes, numero_indentificacao_sms');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function listarempresapermissoes($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select('e.empresa_id,
                            ordem_chegada,
                            promotor_medico,
                            excluir_transferencia,
                            orcamento_config,
                            rodape_config,
                            ep.valor_autorizar,
                            ep.gerente_contasapagar,
                            ep.cpf_obrigatorio,
                            ep.orcamento_recepcao,
                            ep.relatorio_ordem,
                            ep.relatorio_producao,
                            ep.relatorios_recepcao,
                            ep.financeiro_cadastro,                            
                            cabecalho_config,
                            valor_recibo_guia,
                            odontologia_valor_alterar,
                            selecionar_retorno,
                            oftamologia,
                            ');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function atualizandoaniversariantestabelasms($aniversariantes, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_aniversariante');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_aniversariante;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($aniversariantes as $item) {
            if ($i <= $disponivel) {
                $this->db->set('paciente_id', $item->paciente_id);
                $numero = ($item->celular != '') ? $item->celular : $item->telefone;
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('mensagem', $mensagem);
                $this->db->set('tipo', 'ANIVERSARIANTE');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function verificacaosmsdia() {
        $empresa_id = $this->session->userdata('empresa_id');

        $horario = date('Y-m-d');

        $this->db->select('COUNT(*) as total');
        $this->db->from('tb_empresa_sms_registro');
        $this->db->where('data_verificacao', $horario);
        $this->db->where('empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function confirmarAtendimentoSMS($agenda_exames_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('confirmacao_por_sms', 't');
        $this->db->set('data_confirmacao_por_sms', $horario);
        $this->db->set('operador_telefonema', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->select('ae.inicio, pt.nome as procedimento, ae.data, p.nome as paciente');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('p.ativo', 't');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function criandoregistrosms() {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date('Y-m-d');
        $periodo = date('m/Y');

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('periodo', $periodo);
        $this->db->set('data_verificacao', $horario);
        $this->db->insert('tb_empresa_sms_registro');
        $registro_sms = $this->db->insert_id();
        return $registro_sms;
    }

    function atualizandoregistro($registro_sms_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $horario = date('Y-m-d');
        $this->db->select('COUNT(*) as total');
        $this->db->from('tb_sms');
        $this->db->where('registrado', 'f');
        $this->db->where('data', $horario);
        $this->db->where('empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();

        $periodo = date('m/Y');
        $total = ($retorno[0]->total != "") ? $retorno[0]->total : 0;
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('periodo', $periodo);
        $this->db->set('qtde', $total);
        $this->db->set('data_verificacao', $horario);
        $this->db->where('empresa_sms_registro_id', $registro_sms_id);
        $this->db->update('tb_empresa_sms_registro');

        $this->db->set('registrado', 't');
        $this->db->where('data', $horario);
        $this->db->update('tb_sms');
    }

    function listarempresapacote() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('quantidade');
        $this->db->from('tb_empresa_sms es');
        $this->db->join('tb_pacote_sms ps', 'ps.pacote_sms_id = es.pacote_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get()->result();
        return (@$return[0]->quantidade != '') ? @$return[0]->quantidade : 0;
    }

    function listarsms() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select("s.sms_id, 
                           s.numero, 
                           s.mensagem, 
                           s.agenda_exames_id, 
                           controle_id, 
                           numero_indentificacao_sms as numero_indentificacao, 
                           s.tipo, 
                           es.endereco_externo,
                           es.remetente_sms");
        $this->db->from('tb_sms s');
        $this->db->join('tb_empresa e', 'e.empresa_id = s.empresa_id');
        $this->db->join('tb_empresa_sms es', 'es.empresa_id = s.empresa_id');
//        $this->db->where('e.razao_social IS NOT NULL');
        $this->db->where('s.mensagem !=', '');
        $this->db->where('s.enviado', 'f');
        $this->db->where('s.ativo', 't');
        $this->db->where('s.empresa_id', $empresa_id);
        $return = $this->db->get()->result_array();

        $this->db->set('enviado', 't');
        $this->db->where('enviado', 'f');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->update('tb_sms');

        return $return;
    }

    function atualizandonumerocontrole($resultado) {
        foreach ($resultado as $item) {
            $sql = "UPDATE ponto.tb_sms SET controle_id={$item["controle_id"]} WHERE sms_id={$item["sms_id"]}";
            $this->db->query($sql);
        }
    }

    function totalutilizado() {
        $periodo = date('m/Y');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('sum(qtde) as total');
        $this->db->from('tb_empresa_sms_registro');
        $this->db->where('periodo', $periodo);
        $this->db->where('empresa_id', $empresa_id);
        $this->db->groupby('empresa_id, periodo');
        $return = $this->db->get()->result();
        return (@$return[0]->total != '') ? @$return[0]->total : '';
    }

    function aniversariantes() {
        $dia = date('d');
        $mes = date('m');
        $this->db->select('p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone');
        $this->db->from('tb_paciente p');
        $this->db->where('p.ativo', 't');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where("EXTRACT(DAY FROM p.nascimento) = $dia AND EXTRACT(MONTH FROM p.nascimento) = $mes");
        $return = $this->db->get();
        return $return->result();
    }

    function atendimentos() {
        $horario = date('d-m-Y');
        $this->db->select('ae.agenda_exames_id,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('p.ativo', 't');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.sms_enviado', 'f');
        $this->db->where('ae.realizada', 't');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where('ae.data', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function examesagendados() {
        $d = (date('N') == 6) ? 2 : 1;
        $diaSeguinte = date('d-m-Y', strtotime("+$d day", strtotime(date('d-m-Y'))));
        $this->db->select('ae.agenda_exames_id,
                           ae.data,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone,
                           pt.nome,
                           ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('p.ativo', 't');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.sms_enviado', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where('p.ativo', 't');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where('ae.data', $diaSeguinte);
//        $this->db->limit(50);
        $return = $this->db->get();
        return $return->result();
    }

    function emailautomatico() {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date('Y-m-d');
        $this->db->set('data_verificacao', $horario);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->insert('tb_empresa_sms_registro');

        $this->db->select('ae.paciente_id,
                           p.nome as paciente,
                           ae.data,
                           p.cns');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where("ae.data", $horario);
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where('p.ativo', 't');
        $this->db->where("(p.cns IS NOT NULL AND p.cns != '')");
        $return = $this->db->get()->result();

        $this->db->select('ae.paciente_id,
                           p.nome as paciente,
                           ae.data,
                           p.cns');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        date_default_timezone_set('America/Fortaleza');

        $totime = strtotime("-1 days");
        $data_atual = date('Y-m-d', $totime);
        $this->db->where('p.ativo', 't');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("(p.cns IS NOT NULL AND p.cns != '')");
        $this->db->where('ae.data', $data_atual);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.realizada', 'f');
        $this->db->where('ae.bloqueado', 'f');
        $this->db->where('ae.operador_atualizacao is not null');
        $faltas = $this->db->get()->result();

        $this->db->select('p.nome as paciente,
                           ae.data_revisao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('p.ativo', 't');
        $this->db->where("ae.data_revisao =", ( date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d'))))));
        $this->db->where("(ae.data_revisao IS NOT NULL)");
        $revisoes = $this->db->get()->result();



        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('email, razao_social, email_mensagem_confirmacao, email_mensagem_falta');
        $this->db->from('tb_empresa');
        $this->db->where("empresa_id", $empresa_id);
        $dadosEmpresa = $this->db->get()->result();

        if ($dadosEmpresa[0]->email != '') {

            $this->load->library('My_phpmailer');
            $mail = new PHPMailer(true);

            foreach ($return as $value) {
                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dadosEmpresa[0]->email;             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = $dadosEmpresa[0]->razao_social;                        // Nome no remetente
                $mail->addAddress($value->cns);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = "Lembrete de Consulta";
                $mail->Body = $dadosEmpresa[0]->email_mensagem_confirmacao;

//                $mail->AddAttachment("./upload/nfe/$solicitacao_cliente_id/validada/" . $notafiscal[0]->chave_nfe . '-danfe.pdf', $notafiscal[0]->chave_nfe . '-danfe.pdf');

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }
            }

            foreach ($faltas as $value) {
                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dadosEmpresa[0]->email;             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = $dadosEmpresa[0]->razao_social;                        // Nome no remetente
                $mail->addAddress($value->cns);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = "";
                $mail->Body = $dadosEmpresa[0]->email_mensagem_falta;

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }
            }

            foreach ($revisoes as $item) {
                $msg = "O paciente: " . $item->paciente . " tem uma revisão marcada para a data " . date("d/m/Y", strtotime($item->data_revisao));
                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dadosEmpresa[0]->email;             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = "SISTEMA STG";                        // Nome no remetente
                $mail->addAddress($value->cns);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = "Revisao";
                $mail->Body = $msg;

//                    $mail->AddAttachment("./upload/nfe/$solicitacao_cliente_id/validada/" . $notafiscal[0]->chave_nfe . '-danfe.pdf', $notafiscal[0]->chave_nfe . '-danfe.pdf');

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }
            }
        }
    }

    function verificaemail() {
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('data_verificacao');
        $this->db->from('tb_empresa_email_verificacao');
        $this->db->where('data_verificacao', $horario);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificasms() {
        $horario = date("Y-m-d");
        $this->db->select('data_verificacao');
        $this->db->from('tb_empresa_sms_registro');
        $this->db->where('data_verificacao', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function listar() {

        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function sair() {
        $operador_id = $this->session->userdata('operador_id');
        $horario = date(" Y-m-d H:i:s");

        $this->db->set('horario_logout', $horario);
        $this->db->where('operador_id', $operador_id);
        $this->db->update('tb_operador');
    }

}

?>
