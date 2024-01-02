<div class="modal otherModal fade " id="cadastroUsuario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastrar usuário</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroUsuarios" class="form-controls">
        <input type="hidden" name="usuario_id" value="">
            <div class="col-sm-12 input">
                  <label for="nomeUsuario">Usuário</label>
                  <input type="name" name="usuario" class="form-control" minlength="5" maxlength="45">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-12 input">
                  <label for="emailUsuario">Senha</label>
                  <input type="password" name="senha" class="form-control" minlength="5" maxlength="50">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <hr>
          <h3 align="center" class="permTitle">Permissões</h3>
            <div class="col-sm-12 row permissoes">
              <!--PRODUTOS-->
              <div class="col-sm-4">
                <strong>Bolos</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="BOL" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="BOL" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="BOL" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--SERVICOS-->
              <div class="col-sm-4">
                <strong>Tortas</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="TOR" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="TOR">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="TOR" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--COMISSOES-->
              <div class="col-sm-4">
                <strong>Doces e Brigadeiros</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="DOC" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="DOC">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="DOC" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--RELATORIOS-->
              <div class="col-sm-4">
                <strong>Embalagens</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="EMB" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <!--editar-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="2" name="EMB">
                  <label class="form-check-label" for="flexCheckDefault">
                    Modificar
                  </label>
                </div>
                <!--excluir-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="EMB" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--VENDAS-->
              <div class="col-sm-4">
                <strong>Pedidos</strong>
                <!--ler-->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="PED" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Visualizar
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="3" name="PED" >
                  <label class="form-check-label" for="flexCheckDefault">
                    Excluir
                  </label>
                </div>
                <!---->
              </div>
              <!--FIM PERMS-->
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger bt_excluir_usuario">Excluir</button>
        <button type="button" class="btn btn-formiga bt_salvar_usuario">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
